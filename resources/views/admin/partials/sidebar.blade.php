<aside>
    <nav>
        <ul>
            <li><a href="{{ route('admin.home') }}"
                    class="{{ Route::currentRouteName() === 'admin.home' ? 'aside-active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li><a href="{{ route('admin.projects.index') }}"
                    class="{{ Route::currentRouteName() === 'admin.projects.index' ? 'aside-active' : '' }}">
                    <i class="fa-solid fa-folder"></i> Projects
                </a>
            </li>
            <li><a href="{{ route('admin.projects-types') }}"
                    class="{{ Route::currentRouteName() === 'admin.projects-types' ? 'aside-active' : '' }}">
                    <i class="fa-solid fa-folder-tree"></i> Projects by Types
                </a>
            </li>
            <li><a href="{{ route('admin.projects.create') }}"
                    class="{{ Route::currentRouteName() === 'admin.projects.create' ? 'aside-active' : '' }}">
                    <i class="fa-solid fa-folder-plus"></i> New Project
                </a>
            </li>
            <li><a href="{{ route('admin.technologies.index') }}"
                    class="{{ Route::currentRouteName() === 'admin.technologies.index' ? 'aside-active' : '' }}">
                    <i class="fa-solid fa-code"></i> Technologies
                </a>
            </li>
            <li><a href="{{ route('admin.types.index') }}"
                    class="{{ Route::currentRouteName() === 'admin.types.index' ? 'aside-active' : '' }}">
                    <i class="fa-solid fa-laptop-code"></i> Types
                </a>
            </li>
        </ul>
    </nav>
</aside>
