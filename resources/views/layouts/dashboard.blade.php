<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Maker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      body{
        background: #eceef3;
      }
      
      a{
        text-decoration: none;
        color: currentColor;
      }
    </style>
    @yield('css')
  </head>
  <body>

    <div class="container mt-3">
        <div class="row mb-3">
            <div class="col">
                <div class="card" style="border-radius: 10px;border:transparent;">
                  <div class="card-body">
                    <a href="/">
                      <div class="row">
                        <div class="col text-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-feather" viewBox="0 0 16 16">
                            <path d="M15.807.531c-.174-.177-.41-.289-.64-.363a3.8 3.8 0 0 0-.833-.15c-.62-.049-1.394 0-2.252.175C10.365.545 8.264 1.415 6.315 3.1S3.147 6.824 2.557 8.523c-.294.847-.44 1.634-.429 2.268.005.316.05.62.154.88q.025.061.056.122A68 68 0 0 0 .08 15.198a.53.53 0 0 0 .157.72.504.504 0 0 0 .705-.16 68 68 0 0 1 2.158-3.26c.285.141.616.195.958.182.513-.02 1.098-.188 1.723-.49 1.25-.605 2.744-1.787 4.303-3.642l1.518-1.55a.53.53 0 0 0 0-.739l-.729-.744 1.311.209a.5.5 0 0 0 .443-.15l.663-.684c.663-.68 1.292-1.325 1.763-1.892.314-.378.585-.752.754-1.107.163-.345.278-.773.112-1.188a.5.5 0 0 0-.112-.172M3.733 11.62C5.385 9.374 7.24 7.215 9.309 5.394l1.21 1.234-1.171 1.196-.027.03c-1.5 1.789-2.891 2.867-3.977 3.393-.544.263-.99.378-1.324.39a1.3 1.3 0 0 1-.287-.018Zm6.769-7.22c1.31-1.028 2.7-1.914 4.172-2.6a7 7 0 0 1-.4.523c-.442.533-1.028 1.134-1.681 1.804l-.51.524zm3.346-3.357C9.594 3.147 6.045 6.8 3.149 10.678c.007-.464.121-1.086.37-1.806.533-1.535 1.65-3.415 3.455-4.976 1.807-1.561 3.746-2.36 5.31-2.68a8 8 0 0 1 1.564-.173"/>
                          </svg>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col text-muted text-center">
                          <h5>Invoice Maker</h5>
                          <hr>
                        </div>
                      </div>
                    </a>
                    <div class="row justify-content-center">
                      <div class="col-auto text-center">
                          <div class="nav-item dropdown">
                            <a class="nav-link text-muted fw-semibold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <small>Hi {{auth()->user()->name}}</small>
                            </a>
                            <ul class="dropdown-menu">
                              <li>
                                <a class="dropdown-item fw-semibold" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                  <small><i class="bi bi-box-arrow-left me-1"></i> Logout</small>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                              </li>
                            </ul>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @yield('contents')
    </div>

    <div class="container my-3">
      <div class="row">
        <div class="col text-center">
          
          <div class="card" style="border-radius: 10px;border:transparent;">
            <div class="card-body">
              <small class="fw-bold text-muted">
                2024, Invoice Maker <i class="bi bi-feather"></i>
              </small>
            </div>
          </div>

        </div>
      </div>
    </div>


    @yield('javascript')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>