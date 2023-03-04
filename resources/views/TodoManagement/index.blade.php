@extends('../template')

@section('main-content')
<section id="updateinfo">
    <div class="container pt-5">
        <div class="row pt-5">
            <div class="col-md-9 mx-auto">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Task</h2>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ url('/todo/create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> add todo</a>
                    </div>
                </div>
                @if($todos->count() != 0)
                @foreach ($todos as $todo)
                <div class="row p-2">
                    <div class="card col-12 p-0">
                        <div class="card-header">
                            Task 1
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Final project Web programming</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                            <hr>
                            <a href="#" class="btn btn-primary">Do task</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="row p-2">
                    <div class="card col-12 p-0">
                        <div class="card-body p-5">
                            <h5 class="card-title">You are not having any todo</h5>
                            <p class="card-text">You can assign your todo in the button above.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection