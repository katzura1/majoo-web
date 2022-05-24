<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="{{ asset('img/AdminLTELogo.png') }}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('logins/fonts/icomoon/style.css') }}" />

  <link rel="stylesheet" href="{{ asset('logins/css/owl.carousel.min.css') }}" />

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('logins/css/bootstrap.min.css') }}" />

  <!-- Style -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('logins/css/style.css') }}" />

  <title>POS MINI {{ isset($title) ? " | ".$title : "" }}</title>
</head>

<body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-2">
          <img src="{{ asset('logins/images/undraw_file_sync_ot38.svg') }}" alt="Image" class="img-fluid" />
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
                <h3>Sign In to <strong>POS MINI</strong></h3>
                <p class="mb-4">
                  Welcome back. Please login to your account.
                </p>
              </div>
              <form id="form_login" method="post">
                  @csrf
                <div class="form-group first">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" minlength="6" required />
                </div>
                <div class="form-group last mb-4">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" minlength="6" required />
                </div>

                <input type="submit" value="Log In" class="btn text-white btn-block btn-danger" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="loader" class="lds-dual-ring hidden overlay"></div>
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('logins/js/main.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <!-- Inputmask-->
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.js') }}"></script>
  <script>
    var token = "{{ csrf_token() }}";
    var Toast = Swal.mixin({
        toast: true,
        position: "center",
        showConfirmButton: false,
        timer: 3000,
    });

    $(document).ready(function () {
        $("#form_login").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{ route('login') }}",
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                beforeSend: function () {
                    // $("#loader").removeClass("hidden");
                    Swal.fire({
                        title: 'Loading',
                        html: 'Please wait...',
                        willOpen: () => {
                            Swal.showLoading()
                        },
                        showConfirmButton : false,
                        clickOutside : false,
                        allowOutsideClick : false,
                    });
                },
                success: function (result) {
                    Swal.close();
                    try {
                        if (result.code == 200) {
                            Swal.fire({
                                icon: "success",
                                title: "Success Login.",
                                showConfirmButton: false,
                                timer: 1000,
                            }).then(() => {
                                window.location.href = "{{ url('home') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: result.message,
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    }
                },
                error: function (xhr, ajax, opt) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed Login.",
                    });
                },
            });
        });
    });
  </script>
</body>

</html>
