                <li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<img src="{{ URL::to('admin_files/global_assets/images/lang/gb.png') }}" class="img-flag mr-2" alt="">
						English
					</a>

					<div class="dropdown-menu dropdown-menu-right">
                    @if(Helper::locale() == 'app_locale')
                        @if(Session::get('app_locale') == 'en')
                            <?php $en = 'active'; $sp = '';$pt=""?>
                        @endif
                        @if(Session::get('app_locale') == 'sp')
                            <?php $sp = 'active'; $en = '';$pt=""?>
                        @endif
                        @if(Session::get('app_locale') == 'pt')
                            <?php $pt = 'active'; $sp = '';$en=""?>
                        @endif
                        <a href="{{ URL::to('admin/set-lang/en') }}" class="dropdown-item english {{ $en }}"><img src="{{ URL::to('admin_files/global_assets/images/lang/gb.png') }}" class="img-flag" alt=""> English</a>
                        <a href="{{ URL::to('admin/set-lang/sp') }}" class="dropdown-item espana {{ $sp }}"><img src="{{ URL::to('admin_files/global_assets/images/lang/es.png') }}" class="img-flag" alt=""> España</a>
                        <a href="{{ URL::to('admin/set-lang/pt') }}" class="dropdown-item russian {{ $pt }}"><img src="{{ URL::to('admin_files/global_assets/images/lang/pt.png') }}" class="img-flag" alt=""> português</a>
                        <!-- @if(Session::get('app_locale') == 'en')
						    <a href="{{ URL::to('admin/set-lang/en') }}" class="dropdown-item english active"><img src="{{ URL::to('admin_files/global_assets/images/lang/gb.png') }}" class="img-flag" alt=""> English</a>
                        @endif -->
						<!-- <a href="#" class="dropdown-item ukrainian"><img src="{{ URL::to('admin_files/global_assets/images/lang/ua.png') }}" class="img-flag" alt=""> Українська</a>
						<a href="#" class="dropdown-item deutsch"><img src="{{ URL::to('admin_files/global_assets/images/lang/de.png') }}" class="img-flag" alt=""> Deutsch</a> -->
						<!-- @if(Session::get('app_locale') == 'sp')
                            <a href="{{ URL::to('admin/set-lang/sp') }}" class="dropdown-item espana active"><img src="{{ URL::to('admin_files/global_assets/images/lang/es.png') }}" class="img-flag" alt=""> España</a>
						@endif
                        @if(Session::get('app_locale') == 'pt')
                            <a href="{{ URL::to('admin/set-lang/pt') }}" class="dropdown-item russian active"><img src="{{ URL::to('admin_files/global_assets/images/lang/pt.png') }}" class="img-flag" alt=""> português</a>
                        @endif -->
                    @endif
                    </div>
				</li>