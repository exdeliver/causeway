<a href="/ajax/like/type/{{ $likeType }}/id/{{$likeId}}" class="btn-like btn-like-action btn btn-sm btn-primary btn-counter"
   data-placement="bottom" data-count="{{ $likeObject->likesCount ?? 0 }}" data-html="true"
   data-toggle="tooltip"
   @if($likeObject->likesCount > 0)
   title="
<ul>
   @foreach($likeObject->likesByUsers as $user)
           <li>{{ $user->name }}</li>
   @endforeach

           </ul>"
        @endif
><i class="fa fa-heart"></i> &nbsp;&nbsp;{{ $likeObject->likesCount ?? 0 }}</a>