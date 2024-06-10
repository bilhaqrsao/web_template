<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-center">

        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
          <li class="breadcrumb-item">
            <i class="bi bi-house lh-1"></i>
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Home</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            Dashboard
          </li>
        </ol>
        <!-- Breadcrumb end -->

        <!-- Filter start -->
        <div class="ms-auto d-flex flex-row gap-1 day-filters">
          <button class="btn btn-sm">Today</button>
          <button class="btn btn-sm">7D</button>
          <button class="btn btn-sm">2W</button>
          <button class="btn btn-sm">1M</button>
          <button class="btn btn-sm">3M</button>
          <button class="btn btn-sm">6M</button>
          <button class="btn btn-sm btn-info">1Y</button>
        </div>
        <!-- Filter end -->

      </div>
      <!-- App Hero header ends -->

      <!-- App body starts -->
      <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
              <div class="card-body">
                <div class="mb-2">
                  <i class="bi bi-bar-chart fs-1 text-primary lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="m-0 fw-normal">Sales</h5>
                  <h3 class="m-0 text-primary">3500</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
              <div class="card-body">
                <div class="mb-2">
                  <i class="bi bi-bag-check fs-1 text-primary lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="m-0 fw-normal">Orders</h5>
                  <h3 class="m-0 text-primary">2900</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
              <div class="card-body">
                <div class="arrow-label">+18%</div>
                <div class="mb-2">
                  <i class="bi bi-box-seam fs-1 text-primary lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="m-0 fw-normal">Items</h5>
                  <h3 class="m-0 text-primary">6500</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
              <div class="card-body">
                <div class="arrow-label">+21%</div>
                <div class="mb-2">
                  <i class="bi bi-check-circle fs-1 text-danger lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="m-0 fw-normal">Signups</h5>
                  <h3 class="m-0 text-danger">7200</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Row end -->

        <!-- Row start -->
        <div class="row gx-3">
          <div class="col-xxl-12">
            <div class="card mb-3">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Overview</h5>
                <button class="btn btn-outline-primary btn-sm ms-auto">
                  Download
                </button>
              </div>
              <div class="card-body">
                <!-- Row start -->
                <div class="row gx-3">
                  <div class="col-lg-5 col-sm-12 col-12">
                    <h6 class="text-center mb-3">Visitors</h6>
                    <div id="visitors"></div>
                    <div class="my-3 text-center">
                      <div class="badge bg-danger bg-opacity-10 text-danger">
                        10% higher than last month
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2 col-sm-12 col-12">
                    <div class="border rounded-4 px-2 py-4 h-100 text-center">
                      <h6 class="mt-3 mb-5">Monthly Average</h6>
                      <div class="mb-5">
                        <h2 class="text-primary">9600</h2>
                        <h6>Visitors</h6>
                      </div>
                      <div class="mb-4">
                        <h2 class="text-danger">$450<sup>k</sup></h2>
                        <h6>Sales</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5 col-sm-12 col-12">
                    <h6 class="text-center mb-3">Sales</h6>
                    <div id="sales"></div>
                    <div class="my-3 text-center">
                      <div class="badge bg-primary bg-opacity-10 text-primary">
                        12% higher than last month
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Row ends -->
              </div>
            </div>
          </div>
        </div>
        <!-- Row ends -->

        <!-- Row start -->
        <div class="row gx-3">
          <div class="col-xl-8 col-lg-12">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="card-title">Team Activity</h5>
              </div>
              <div class="card-body">
                <ul class="m-0 p-0">
                  <li class="team-activity d-flex flex-wrap">
                    <div class="activity-time py-2 me-3">
                      <p class="m-0">10:30AM</p>
                      <span class="badge bg-primary">New</span>
                    </div>
                    <div class="d-flex flex-column py-2">
                      <h6>Earth - Admin Dashboard</h6>
                      <p class="m-0">by Elnathan Lois</p>
                    </div>
                    <div class="ms-auto mt-4">
                      <div class="progress small mb-1">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p>(225 of 700gb)</p>
                    </div>
                  </li>
                  <li class="team-activity d-flex flex-wrap">
                    <div class="activity-time py-2 me-3">
                      <p class="m-0">11:30AM</p>
                      <span class="badge bg-primary">Task</span>
                    </div>
                    <div class="d-flex flex-column py-2">
                      <h6>Bootstrap Gallery Admin Templates</h6>
                      <p class="m-0">by Patrobus Nicole</p>
                    </div>
                    <div class="ms-auto mt-4">
                      <div class="progress small mb-1">
                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p>90% completed</p>
                    </div>
                  </li>
                  <li class="team-activity d-flex flex-wrap">
                    <div class="activity-time py-2 me-3">
                      <p class="m-0">12:50PM</p>
                      <span class="badge bg-danger">Closed</span>
                    </div>
                    <div class="d-flex flex-column py-2">
                      <h6>Bootstrap Admin Themes</h6>
                      <p class="m-0">by Abilene Omega</p>
                    </div>
                    <div class="ms-auto mt-3">
                      <div id="sparkline1"></div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-12">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="card-title">Tasks</h5>
              </div>
              <div class="card-body">
                <div class="auto-align-graph">
                  <div id="tasks"></div>
                </div>
                <div class="grid text-center">
                  <div class="g-col-4">
                    <i class="bi bi-triangle text-danger"></i>
                    <h3 class="m-0 mt-1">6</h3>
                    <p class="m-0">New</p>
                  </div>
                  <div class="g-col-4">
                    <i class="bi bi-triangle text-primary"></i>
                    <h3 class="m-0 mt-1 fw-bolder">9</h3>
                    <p class="m-0">Pending</p>
                  </div>
                  <div class="g-col-4">
                    <i class="bi bi-triangle text-success"></i>
                    <h3 class="m-0 mt-1">12</h3>
                    <p class="m-0">Completed</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Row end -->

        <!-- Row start -->
        <div class="row gx-3">
          <div class="col-sm-6 col-12">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="card-title">Stats</h5>
              </div>
              <div class="card-body">
                <div class="scroll350">
                  <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-record-fill text-primary me-2"></i>
                    <div class="d-flex p-2 bg-primary rounded-circle me-3">
                      <i class="bi bi-bag fs-4 text-white lh-1"></i>
                    </div>
                    <p class="m-0 me-2">
                      You have spent about <b>65%</b> of your annual budget.
                    </p>
                    <div class="ms-auto badge bg-primary bg-opacity-10 text-primary small">
                      24/12/2023
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-record-fill text-primary me-2"></i>
                    <div class="d-flex p-2 bg-primary rounded-circle me-3">
                      <i class="bi bi-check-circle fs-4 text-white lh-1"></i>
                    </div>
                    <p class="m-0 me-2">
                      New admin dashboard purchased, and payment paid
                      through online.
                    </p>
                    <div class="ms-auto badge bg-primary bg-opacity-10 text-primary small">
                      23/12/2023
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-record-fill text-primary me-2"></i>
                    <div class="d-flex p-2 bg-primary rounded-circle me-3">
                      <i class="bi bi-clipboard-check fs-4 text-white lh-1"></i>
                    </div>
                    <p class="m-0 me-2">
                      A new ticket opened and assigned to <b>Zion</b>.
                    </p>
                    <div class="ms-auto badge bg-primary bg-opacity-10 text-primary small">
                      22/12/2023
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-record-fill me-2"></i>
                    <div class="d-flex p-2 bg-primary rounded-circle me-3">
                      <i class="bi bi-slash-circle fs-4 text-white lh-1"></i>
                    </div>
                    <p class="m-0 me-2">
                      Thanks <b>Sarah</b>, I want you to share Jim's
                      profile.
                    </p>
                    <div class="ms-auto badge bg-primary bg-opacity-10 text-primary small">
                      21/12/2023
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-record-fill me-2"></i>
                    <div class="d-flex p-2 bg-primary rounded-circle me-3">
                      <i class="bi bi-envelope-open fs-4 text-white lh-1"></i>
                    </div>
                    <p class="m-0 me-2">
                      <b>Ora Mahoney,</b> has completed the design of the
                      CRM admin application.
                    </p>
                    <div class="ms-auto badge bg-danger bg-opacity-10 text-danger small">
                      20/12/2023
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-record-fill me-2"></i>
                    <div class="d-flex p-2 bg-primary rounded-circle me-3">
                      <i class="bi bi-envelope-open fs-4 text-white lh-1"></i>
                    </div>
                    <p class="m-0 me-2">
                      <b>Daren Boyd,</b> received the order.
                    </p>
                    <div class="ms-auto badge bg-danger bg-opacity-10 text-danger small">
                      18/12/2023
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-12">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="card-title">Orders</h5>
              </div>
              <div class="card-body">
                <div class="row gx-3">
                  <div class="col-lg-6 col-sm-6 col-12">
                    <div class="d-flex flex-column align-items-start">
                      <div class="icon-box lg border border-primary rounded-5 my-3">
                        <span class="bi bi-bar-chart-line fs-2 text-primary lh-1"></span>
                      </div>
                      <h3 class="mt-4">$780<sup>k</sup></h3>
                      <p class="mb-4">
                        Highest sales growth in last two years.
                      </p>
                      <div class="d-flex p-3 flex-column border border-primary rounded-2 mb-4">
                        <h6>Target - <span>75/100</span></h6>
                        <div class="progress small">
                          <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"
                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <small class="badge bg-primary bg-opacity-10 text-primary rounded-1">47% High growth</small>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-6 col-12">
                    <div id="orders"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="card-title">Sales in USA</h5>
              </div>
              <div class="card-body">

                <!-- Chart starts -->
                <div id="us-map4" class="chart-height-xxl"></div>
                <!-- Chart ends -->

                <div class="grid gap-3 mt-4">
                  <div class="g-col-4">
                    <div class="p-3 flex-column border border-primary rounded-2">
                      <p class="mb-1">Total Sales</p>
                      <h4 class="fw-bold mb-2">$9,800</h4>
                      <div class="progress small">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"
                          aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="g-col-4">
                    <div class="p-3 flex-column border border-primary rounded-2">
                      <p class="mb-1">Active Users</p>
                      <h4 class="fw-bold mb-2">8,900</h4>
                      <div class="progress small">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%"
                          aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="g-col-4">
                    <div class="p-3 flex-column border border-primary rounded-2">
                      <p class="mb-1">Daily Users</p>
                      <h4 class="fw-bold mb-2">3,600</h4>
                      <div class="progress small">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Row ends -->

      </div>
      <!-- App body ends -->
</div>
