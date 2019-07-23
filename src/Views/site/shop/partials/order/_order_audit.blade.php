<table class="table table-striped">
    <thead>
    <tr>
        <th>
            Log
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->audits()->orderBy('created_at','desc')->get() as $audit)
        @if(isset($audit->new_values['status']) !== null && !empty($audit->new_values['status']))
            <tr>
                <td>
                    <small>{{ causewayDate($audit->created_at,'j M Y H:i:s') }}</small>
                    <br/>

                    <strong>Order status updated</strong><br/>
                    <code>{{ ucwords(str_replace('_', ' ', $audit->new_values['status'])) ?? '' }}</code>

                    @if(isset($audit->new_values['paid_at']))
                        <br/><strong>Order paid</strong> <br/>
                    @endif

                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>