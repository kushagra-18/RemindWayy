@include('essential.navbar')

<title> Home Page | {{ Auth::user()->name }} </title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    @if(!Auth()->user()->phone)
        @include('essential.addphone')
    @endif
        <!-- ADD REMINDER -->
        @include('essential.addreminder')
        <!-- SHOW REMINDER -->
        @include('essential.showreminder')
    </div>
</div>