<footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-center text-md-left text-primary">
                <p class="mb-2 mb-md-0">{{ Str::upper(request()->getHost()) }} &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<!-- JavaScript files-->
<script src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"> </script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="{{ asset('js/charts-home.js') }}"></script>
<script src="{{ asset('js/front.js') }}"></script>
</body>
</html>
