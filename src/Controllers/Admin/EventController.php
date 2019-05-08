<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Event\CalendarItem;
use Exdeliver\Causeway\Domain\Services\EventService;
use Exdeliver\Causeway\Requests\PostEventRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class EventController
 * @package Exdeliver\Causeway\Controllers\Admin
 */
class EventController extends Controller
{
    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * EventController constructor.
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $calendar = \Calendar::addEvents(CalendarItem::get()); //add an array with addEvents

        return view('causeway::admin.events.index', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('causeway::admin.events.new');
    }

    /**
     * @param Request $request
     * @param CalendarItem $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, CalendarItem $event)
    {
        return view('causeway::admin.events.update', [
            'event' => $event,
        ]);
    }

    /**
     * @param PostEventRequest $request
     * @param CalendarItem $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostEventRequest $request, CalendarItem $event)
    {
        return $this->store($request, $event);
    }

    /**
     * @param PostEventRequest $request
     * @param CalendarItem|null $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostEventRequest $request, CalendarItem $event = null)
    {
        $this->eventService->updateOrCreate([
            'id' => $event->id ?? null,
        ], $request->only([
            'title',
            'slug',
            'description',
            'user_id',
            'start_datetime',
            'end_datetime',
        ]));

        $request->session()->flash('status', isset($event->id) && $event->id !== null ? 'Event has successfully been updated!' : 'Event has successfully been created!');

        return redirect()
            ->route('admin.events.index');
    }

    /**
     * @param Request $request
     * @param CalendarItem $event
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, CalendarItem $event)
    {
        $event->delete();

        return redirect()
            ->back();
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAjaxEvents()
    {
        $events = CalendarItem::get();

        return Datatables::of($events)
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->addColumn('start_datetime', function ($row) {
                return $row->start_datetime;
            })
            ->addColumn('end_datetime', function ($row) {
                return $row->end_datetime;
            })
            ->addColumn('manage', function ($row) {
                return '<a href="' . route('admin.events.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="' . route('admin.events.remove', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>
                        ';
            })
            ->rawColumns(['title', 'start_datetime', 'end_datetime', 'manage'])
            ->make(true);
    }
}
