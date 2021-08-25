<div id="aside" class="app-aside modal fade folded md nav-expand">
    <div class="left navside indigo-900 dk" layout="column">
        <div class="navbar navbar-md no-radius">
            <router-link to="/dashboard" class="navbar-brand">
                <div ui-include="'../assets/images/logo.svg'"></div>
                <img src="../assets/images/logo.png" alt="." class="hide">
                <span class="hidden-folded inline">Cod-kech</span>
            </router-link>
        </div>
        <div flex class="hide-scroll">
            <nav class="scroll nav-active-primary">
                <ul class="nav" ui-nav>
                    <li class="nav-header hidden-folded">
                        <small class="text-muted">Main</small>
                    </li>
                    <li>
                        <router-link to="/dashboard">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3fc;
                                    <span ui-include="'../assets/images/i_0.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Dashboard</span>
                        </router-link>
                    </li>

                    <li>
                        <router-link to="/orders">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-label">
                                <b class="label rounded label-sm primary">5</b>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe5c3;
                                    <span ui-include="'../assets/images/i_1.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Orders</span>
                        </router-link>
                        <ul class="nav-sub">
                            <li>
                                <router-link to="orders">
                                    <span class="nav-text">List</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/orders/add">
                                    <span class="nav-text">Add</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/sources">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-label">
                                <b class="label rounded label-sm primary">5</b>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe5c3;
                                    <span ui-include="'../assets/images/i_1.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Sale channel</span>
                        </router-link>
                        <ul class="nav-sub">
                            <li>
                                <router-link to="sources">
                                    <span class="nav-text">List</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/sources/add">
                                    <span class="nav-text">Add</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <router-link to="/consumers">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe8f0;
                                    <span ui-include="'../assets/images/i_2.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Customers</span>
                        </router-link>
                        <ul class="nav-sub">
                            <li>
                                <router-link to="/consumers">
                                    <span class="nav-text">List</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/consumers/add">
                                    <span class="nav-text">Add</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <router-link to="#" href="widget.html">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe8d2;
                                    <span ui-include="'../assets/images/i_3.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Analytics</span>
                        </router-link>
                    </li>

                    <li class="nav-header hidden-folded">
                        <small class="text-muted">Main</small>
                    </li>

                    <li>
                        <router-link to="/shippings/company">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>

                            <span class="nav-icon">
                                <i class="material-icons">&#xe429;
                                    <span ui-include="'../assets/images/i_4.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Company</span>
                        </router-link>
                        <ul class="nav-sub nav-mega nav-mega-3">
                            <li>
                                <router-link to="/shippings/company">
                                    <span class="nav-text">delivery company</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/shippings/men">
                                    <span class="nav-text">delivery man</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/shippings/men">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-label">
                                <b class="label label-sm accent">8</b>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe429;
                                    <span ui-include="'../assets/images/i_4.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Delivery</span>
                        </router-link>
                        <ul class="nav-sub nav-mega nav-mega-3">
                            <li>
                                <router-link to="/shippings/company">
                                    <span class="nav-text">delivery company</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/shippings/men">
                                    <span class="nav-text">delivery man</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/products">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-label"><b class="label no-bg">9</b></span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3e8;
                                    <span ui-include="'../assets/images/i_6.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Product</span>
                        </router-link>
                    </li>

                    <li>
                        <router-link to="#">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe39e;
                                    <span ui-include="'../assets/images/i_6.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Transaction</span>
                        </router-link>
                        <ul class="nav-sub">

                        </ul>
                    </li>

                    <li>
                        <router-link to="#">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe896;
                                    <span ui-include="'../assets/images/i_7.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Users</span>
                        </router-link>
                        <ul class="nav-sub">
                            <li>
                                <router-link to="/users">
                                    <span class="nav-text">list</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/users/add">
                                    <span class="nav-text">add</span>
                                </router-link>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <router-link to="#">
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-label hidden-folded">
                                <b class="label label-sm info">N</b>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe1b8;
                                    <span ui-include="'../assets/images/i_8.svg'"></span>
                                </i>
                            </span>
                            <span class="nav-text">Settings</span>
                        </router-link>
                        <ul class="nav-sub">
                            <li>
                                <router-link to="#" href="chart.html">
                                    <span class="nav-text">Chart</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="#">
                                    <span class="nav-caret">
                                        <i class="fa fa-caret-down"></i>
                                    </span>
                                    <span class="nav-text">Echarts</span>
                                </router-link>
                                <ul class="nav-sub">
                                    <li>
                                        <router-link to="#" href="echarts-line.html">
                                            <span class="nav-text">line</span>
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#" href="echarts-bar.html">
                                            <span class="nav-text">Bar</span>
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#" href="echarts-pie.html">
                                            <span class="nav-text">Pie</span>
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#" href="echarts-scatter.html">
                                            <span class="nav-text">Scatter</span>
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#" href="echarts-radar-chord.html">
                                            <span class="nav-text">Radar &amp; Chord</span>
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#" href="echarts-gauge-funnel.html">
                                            <span class="nav-text">Gauges &amp; Funnel</span>
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="#" href="echarts-map.html">
                                            <span class="nav-text">Map</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header hidden-folded">
                        <small class="text-muted">Help</small>
                    </li>

                    <li class="hidden-folded">
                        <router-link to="#" href="docs.html">
                            <span class="nav-text">Documents</span>
                        </router-link>
                    </li>


                </ul>
            </nav>
        </div>
    </div>
</div>
