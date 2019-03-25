<template>
    <li class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="commenterImage">
            @if(file_exists($comment->profile_picture ?? '/images/placeholder_profile.png'))
            <img alt="User" src="{{ $comment->profile_picture ?? '/images/placeholder_profile.png' }}"/>
            @endif
        </div>
        <div class="commentText">
            <p><strong>{{ $comment->name }}</strong></p>
            <p>{{ $comment->comment }}</p>
            <span class="date sub-text">on {{ $comment->created_at->diffForHumans() }}</span>
            {{--| --}}
            {{--@include('pandaLike.like', [--}}
            {{--'likeObject' => $comment,--}}
            {{--'likeId' => $comment->id,--}}
            {{--'likeType' => 'pandaComment'--}}
            {{--])--}}
        </div>
    </li>
</template>

<script>
    export default {
        mounted() {
            console.log('Forum index mounted.');
        },
        props: [],
        data: function () {
            return {
                loginDetails: {
                    email: '',
                    password: ''
                },
            }
        },
        connect() {
            window.Echo.private('users.notification.thread.' + Laravel.threadId)
                .listen('CommentNotificationCreated', (data) => {
                    console.log(data);
                    alert('trigger');
                });
        },
        methods: {}
    }
</script>
