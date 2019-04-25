<template>
    <table class="footable table table-striped table-bordered table-white table-hover default footable-loaded">
        <thead>
        <tr>
            <th class="footable-visible footable-first-column" data-class="expand"><i class="fa fa-list-ol"></i> <a
                    data-original-title="" href="" title="">{{ category.title }}</a><br/><span v-html="category.description">{{ category.description }}</span></th>
            <th class="large80 footable-visible" data-hide="phone"><i class="fa fa-bar-chart-o"></i> Statistics</th>
            <th class="large20 footable-visible footable-last-column" data-hide="phone"><i class="fa fa-comments-o"></i> Last post</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="subcategory in category.children">
            <td class="expand footable-visible footable-first-column" title="No unread posts"><span class="footable-toggle"></span>
                <span class="icon-wrapper">
                             <i class="row-icon-font icon-moon-default forum-read" title="No unread posts"></i>
                            </span>
                <i class="row-icon-font-mini " title="No unread posts"></i>
                <a class="btn-rss pull-right hidden-xs hidden-sm" data-original-title="Feed - Your first forum" href="http://www.sitesplat.com/demo/phpBB3/feed.php?f=2"
                   title=""><i class="fa fa-rss rss-color-forum"></i></a> <span class="desc-wrapper">
                        <a :href="subcategory.fqn_slug" class="forumtitle" data-original-title="" title="">{{ subcategory.title }}</a><br>
                        <span class="description" v-html="subcategory.description">{{ subcategory.description }}</span><br>
            </span>
            </td>
            <td class="stats-col footable-visible">
                         <span class="stats-wrapper">
                         {{ subcategory.count_threads }}&nbsp;Topics&nbsp;<br>{{ subcategory.count_replies }}&nbsp;Replies
			 			 </span>
            </td>
            <td class="footable-visible footable-last-column">
        			  <span class="last-wrapper text-overflow">
                            <a class="lastsubject" data-original-title="" :href="subcategory.latest_replied_thread_link" title="">Re: {{ subcategory.latest_replied_thread_title }}</a><br/>
								by&nbsp;<a class="username" data-original-title="" :href="subcategory.latest_replied_thread_link" title="">{{ subcategory.latest_replied_user }}</a>
				            <a class="moderator-item" data-original-title="View the latest post" :href="subcategory.latest_replied_thread_link" title=""><i
                                    class="mobile-post fa fa-sign-out"></i></a><br/>
                          <span class="forum-time">{{ subcategory.latest_replied_date }}</span>
                      </span>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import Message from './MessageComponent.vue';

    export default {
        mounted() {
            console.log('Forum index mounted.');
        },
        props: ['category'],
        components: {
            Message
        },
        data: function () {
            return {
                loginDetails: {
                    email: '',
                    password: ''
                },
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message)
            }
        },
        methods: {}
    }
</script>
