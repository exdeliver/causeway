<div class="profile-sidebar">
    <ul class="list-group">
        <li>
            <a class="list-group-item"><i class="fa fa-home"></i> <span>Navigation</span></a>
        </li>
        <li><a href="{{ route('causeway.dashboard') }}" class="list-group-item {{ (request()->is('admin/dashboard'))? 'active' :'' }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>
        <li><a href="{{ route('admin.pages.index') }}" class="list-group-item {{ (request()->is('admin/pages*'))? 'active' :'' }}"><i class="fa fa-file"></i> <span>Pages</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.pages.create') }}" class="list-group-item"><i class="fa fa-file-text"></i> <span>New page</span></a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.menu.index') }}" class="list-group-item {{ (request()->is('admin/menu*'))? 'active' :'' }}"><i class="fa fa-list"></i> <span>Menus</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.menu.create') }}" class="list-group-item"><i class="fa fa-list-ul"></i> <span>New menu</span></a></li>
            </ul>
        </li>
        <li><a href="#" class="list-group-item {{ (request()->is('admin/shop*'))? 'active' :'' }}"><i class="fa fa-shopping-cart"></i> <span>Webshop</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.shop.order.index') }}" class="list-group-item"><i class="fa fa-euro"></i> <span>Sales</span></a></li>
                <li><a href="{{ route('admin.shop.product.index') }}" class="list-group-item"><i class="fa fa-book"></i> <span>Products</span></a></li>
                <li><a href="{{ route('admin.shop.category.index') }}" class="list-group-item"><i class="fa fa-bandcamp"></i> <span>Categories</span></a></li>
{{--                <li><a href="{{ route('admin.shop.customer.index') }}" class="list-group-item"><i class="fa fa-address-book"></i> <span>Customers</span></a></li>--}}
                <li><a href="{{ route('admin.shop.couponcode.index') }}" class="list-group-item"><i class="fa fa-ticket"></i> <span>Coupon codes</span></a></li>
                <li><a href="{{ route('admin.shop.shipping-method.index') }}" class="list-group-item"><i class="fa fa-envelope"></i> <span>Shipping methods</span></a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.events.index') }}" class="list-group-item {{ (request()->is('admin/events*'))? 'active' :'' }}"><i class="fa fa-calendar"></i> <span>Events</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.events.create') }}" class="list-group-item"><i class="fa fa-calendar-check-o"></i> <span>New event</span></a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.photo.album.index') }}" class="list-group-item {{ (request()->is('admin/photo/album*'))? 'active' :'' }}"><i class="fa fa-photo"></i> <span>Photos</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.photo.album.new') }}" class="list-group-item"><i class="fa fa-file-photo-o"></i> <span>New album</span></a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.forum.index') }}" class="list-group-item {{ (request()->is('admin/forum*'))? 'active' :'' }}"><i class="fa fa-foursquare"></i> <span>Forum</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/forum/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.forum.create') }}" class="list-group-item"><i class="fa fa-foursquare"></i> <span>New category</span></a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.sound.index') }}" class="list-group-item {{ (request()->is('admin/sound/album*'))? 'active' :'' }}"><i class="fa fa-music"></i> <span>Sound</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.sound.create') }}" class="list-group-item"><i class="fa fa-music"></i> <span>New sound</span></a></li>
            </ul>
        </li>
        <li><a href="#" class="list-group-item {{ (request()->is('admin/authorisation/*'))? 'active' :'' }}"><i class="fa fa-user"></i> <span>Authorisation</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.authorisation.user.index') }}" class="list-group-item"><i class="fa fa-user"></i> <span>Users</span></a></li>
                <li><a href="{{ route('admin.authorisation.role.index') }}" class="list-group-item"><i class="fa fa-hand-rock-o"></i> <span>Roles</span></a></li>
            </ul>
        </li>
    </ul>
</div>
