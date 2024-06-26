    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <?php
            if ($row['level'] == 'user') {
            ?>
              <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="../dashboard/" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>
            <?php
            } else {
            ?>
              <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="../dashadmin/" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>
            <?php
            }
            ?>
            <li class="list-divider"></li>
            <li class="nav-small-cap"><span class="hide-menu">Applications</span></li>

            <?php
            if ($row['level'] == 'user') {
            ?>
              <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Perhitungan </span></a>
                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                  <li class="sidebar-item"><a href="../jabatan&unitkerja/" class="sidebar-link"><span class="hide-menu"> Kategori Jabatan dan Unit Kerja
                      </span></a>
                  </li>
                  <li class="sidebar-item"><a href="../waktukerjatersedia/" class="sidebar-link"><span class="hide-menu"> Waktu Kerja Tersedia
                      </span></a>
                  </li>
                  <li class="sidebar-item"><a href="../komponenbebankerja/" class="sidebar-link"><span class="hide-menu"> Komponen Beban Kerja
                      </span></a>
                  </li>
                  <li class="sidebar-item"><a href="../normawaktukomponen/" class="sidebar-link"><span class="hide-menu"> Norma Waktu Komponen Beban Kerja
                      </span></a>
                  </li>
                  <li class="sidebar-item"><a href="../standarbebankerja/" class="sidebar-link"><span class="hide-menu"> Standar Beban Kerja
                      </span></a>
                  </li>
                  <li class="sidebar-item"><a href="../standartugaspenunjang/" class="sidebar-link"><span class="hide-menu"> Standar Tugas Penunjang
                      </span></a>
                  </li>
                  <li class="sidebar-item"><a href="../kebutuhantenaga/" class="sidebar-link"><span class="hide-menu"> Kebutuhan Tenaga
                      </span></a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item"> <a class="sidebar-link" href="../dataunitkerjauser/" aria-expanded="false"><i data-feather="percent" class="feather-icon"></i><span class="hide-menu">Riwayat Perhitungan
                  </span></a>
              </li>
            <?php
            }
            ?>
            <?php
            if ($row['level'] == 'admin') {
            ?>
              <li class="sidebar-item"> <a class="sidebar-link" href="../semuapengguna/" aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span class="hide-menu">Data Mahasiswa
                  </span></a>
              </li>
              <li class="sidebar-item"> <a class="sidebar-link" href="../dataunitkerja/" aria-expanded="false"><i data-feather="briefcase" class="feather-icon"></i><span class="hide-menu">Data Unit Kerja
                  </span></a>
              </li>
              <li class="sidebar-item"> <a class="sidebar-link" href="../datauraiankegiatan/" aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Data Uraian Kegiatan
                  </span></a>
              </li>
            <?php
            }
            ?>
            <li class="sidebar-item"> <a class="sidebar-link" href="../profil/" aria-expanded="false"><i data-feather="user" class="feather-icon"></i><span class="hide-menu">Profil
                </span></a>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="#" data-bs-target="#primary-header-modal" data-bs-toggle="modal" aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Logout</span></a></li>
            <!-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="app-chat.html" aria-expanded="false"><i data-feather="message-square" class="feather-icon"></i><span class="hide-menu">Chat</span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="app-calendar.html" aria-expanded="false"><i data-feather="calendar" class="feather-icon"></i><span class="hide-menu">Calendar</span></a></li> -->

            <!-- <li class="list-divider"></li>
            <li class="nav-small-cap"><span class="hide-menu">Components</span></li>
            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Forms </span></a>
              <ul aria-expanded="false" class="collapse  first-level base-level-line">
                <li class="sidebar-item"><a href="form-inputs.html" class="sidebar-link"><span class="hide-menu"> Form Inputs
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="form-input-grid.html" class="sidebar-link"><span class="hide-menu"> Form Grids
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="form-checkbox-radio.html" class="sidebar-link"><span class="hide-menu"> Checkboxes &
                      Radios
                    </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="grid" class="feather-icon"></i><span class="hide-menu">Tables </span></a>
              <ul aria-expanded="false" class="collapse  first-level base-level-line">
                <li class="sidebar-item"><a href="table-basic.html" class="sidebar-link"><span class="hide-menu"> Basic Table
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="table-dark-basic.html" class="sidebar-link"><span class="hide-menu"> Dark Basic Table
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="table-sizing.html" class="sidebar-link"><span class="hide-menu">
                      Sizing Table
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="table-layout-coloured.html" class="sidebar-link"><span class="hide-menu">
                      Coloured
                      Table Layout
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="table-datatable-basic.html" class="sidebar-link"><span class="hide-menu">
                      Basic
                      Datatables
                      Layout
                    </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="bar-chart" class="feather-icon"></i><span class="hide-menu">Charts </span></a>
              <ul aria-expanded="false" class="collapse  first-level base-level-line">
                <li class="sidebar-item"><a href="chart-morris.html" class="sidebar-link"><span class="hide-menu"> Morris Chart
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="chart-chart-js.html" class="sidebar-link"><span class="hide-menu"> ChartJs
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="chart-knob.html" class="sidebar-link"><span class="hide-menu">
                      Knob Chart
                    </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="box" class="feather-icon"></i><span class="hide-menu">UI Elements </span></a>
              <ul aria-expanded="false" class="collapse  first-level base-level-line">
                <li class="sidebar-item"><a href="ui-buttons.html" class="sidebar-link"><span class="hide-menu"> Buttons
                    </span></a>
                </li>
                <li class="sidebar-item"><a href="ui-modals.html" class="sidebar-link"><span class="hide-menu"> Modals </span></a>
                </li>
                <li class="sidebar-item"><a href="ui-tab.html" class="sidebar-link"><span class="hide-menu"> Tabs </span></a></li>
                <li class="sidebar-item"><a href="ui-tooltip-popover.html" class="sidebar-link"><span class="hide-menu"> Tooltip &
                      Popover</span></a></li>
                <li class="sidebar-item"><a href="ui-notification.html" class="sidebar-link"><span class="hide-menu">Notification</span></a></li>
                <li class="sidebar-item"><a href="ui-progressbar.html" class="sidebar-link"><span class="hide-menu">Progressbar</span></a></li>
                <li class="sidebar-item"><a href="ui-typography.html" class="sidebar-link"><span class="hide-menu">Typography</span></a></li>
                <li class="sidebar-item"><a href="ui-bootstrap.html" class="sidebar-link"><span class="hide-menu">Bootstrap
                      UI</span></a></li>
                <li class="sidebar-item"><a href="ui-breadcrumb.html" class="sidebar-link"><span class="hide-menu">Breadcrumb</span></a></li>
                <li class="sidebar-item"><a href="ui-list-media.html" class="sidebar-link"><span class="hide-menu">List
                      Media</span></a></li>
                <li class="sidebar-item"><a href="ui-grid.html" class="sidebar-link"><span class="hide-menu"> Grid </span></a></li>
                <li class="sidebar-item"><a href="ui-carousel.html" class="sidebar-link"><span class="hide-menu">
                      Carousel</span></a></li>
                <li class="sidebar-item"><a href="ui-scrollspy.html" class="sidebar-link"><span class="hide-menu">
                      Scrollspy</span></a></li>
                <li class="sidebar-item"><a href="ui-toasts.html" class="sidebar-link"><span class="hide-menu"> Toasts</span></a>
                </li>
                <li class="sidebar-item"><a href="ui-spinner.html" class="sidebar-link"><span class="hide-menu"> Spinner </span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="ui-cards.html" aria-expanded="false"><i data-feather="sidebar" class="feather-icon"></i><span class="hide-menu">Cards
                </span></a>
            </li>
            <li class="list-divider"></li>
            <li class="nav-small-cap"><span class="hide-menu">Authentication</span></li>

            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="authentication-login1.html" aria-expanded="false"><i data-feather="lock" class="feather-icon"></i><span class="hide-menu">Login
                </span></a>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="authentication-register1.html" aria-expanded="false"><i data-feather="lock" class="feather-icon"></i><span class="hide-menu">Register
                </span></a>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="feather" class="feather-icon"></i><span class="hide-menu">Icons
                </span></a>
              <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><span class="hide-menu"> Fontawesome Icons </span></a></li>

                <li class="sidebar-item"><a href="icon-simple-lineicon.html" class="sidebar-link"><span class="hide-menu"> Simple Line Icons </span></a></li>
              </ul>
            </li>


            <li class="list-divider"></li>
            <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>

            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="authentication-login1.html" aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Logout</span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="crosshair" class="feather-icon"></i><span class="hide-menu">Multi
                  level
                  dd</span></a>
              <ul aria-expanded="false" class="collapse first-level base-level-line">
                <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item 1.1</span></a>
                </li>
                <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item 1.2</span></a>
                </li>
                <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Menu 1.3</span></a>
                  <ul aria-expanded="false" class="collapse second-level base-level-line">
                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item
                          1.3.1</span></a></li>
                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item
                          1.3.2</span></a></li>
                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item
                          1.3.3</span></a></li>
                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item
                          1.3.4</span></a></li>
                  </ul>
                </li>
                <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="hide-menu"> item
                      1.4</span></a></li>
              </ul>
            </li> -->
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->