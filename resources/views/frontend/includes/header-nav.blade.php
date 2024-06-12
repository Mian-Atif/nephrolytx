<!-- partial:partials/_navbar.html -->
<nav class="navbar p-0 d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <div class="side-btn-wrap">
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="ti-align-left"></span>
            </button>
        </div>
        <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo"  style="color:#fff;"><img src="{{ asset('img/images/newlogo.png') }}" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini"  style="color:#fff;"><img src="{{ asset('img/images/newlogo.png') }}" alt="logo"/></a>
        </div>
        <div class="navbar-nav" style="display: none !important;">
        <div class="nav-item nav-search d-none d-sm-flex">
        <div class="nav-link d-flex justify-content-center align-items-center">
                <!-- <i class="ti-search mx-0" id="search-icon"></i> -->
                <img src="{{ asset('img/images/file-icons/search.png') }}" class="search">
                    <input type="text" class="form-control text" id="search-field" placeholder="Start Typing...">
                    
                </div>
            </div>
        </div>
        
        <ul class="navbar-nav navbar-nav-right ml-auto">
            
            <li class="nav-item dropdown" style="display: none;">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                   id="messageDropdown" href="#" data-toggle="dropdown">
                   <img src="{{ asset('img/images/file-icons/message.png') }}" class="menu-icon" style="width: 20px;height: 20px;">
                    
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                     aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                New product launch
                            </p>
                        </div>
                    </a>

                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="https://via.placeholder.com/36x36" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div>
            </li>

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ asset('img/images/user.png') }}" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                     aria-labelledby="profileDropdown">

                        <a class="dropdown-item" href="{!! route('frontend.auth.logout') !!}">
                        <i class="ti-new-window text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
            <span class="ti-menu"></span>
        </button>
    </div>
</nav>
<!-- partial -->