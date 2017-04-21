<li>
    <a href="javascript:void(0);" class="menu-toggle">
        <i class="material-icons">account_circle</i>
        <span>Users</span>
    </a>
    <ul class="ml-menu"  >
        <li>
            <a href="{{ url('admin/user') }}">
                <span>User</span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/group') }}">
                <span>Group</span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/role') }}">
                <span>Role</span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/permission') }}">
                <span>Permission</span>
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript:void(0);" class="menu-toggle">
        <i class="material-icons">insert_emoticon</i>
        <span>Setting</span>
    </a>

    <ul class="ml-menu" style="display: none;">
        <li>
            <a  href="{{ url('admin/icons') }}">
                <span>Icons</span>
            </a>
        </li>
<!--         <li>
            <a href="{{ url('admin/docs') }}">
                <span>docs</span>
            </a>
        </li> -->
    </ul>
</li>


