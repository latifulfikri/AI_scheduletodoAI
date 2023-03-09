@extends('../template')

@section('main-content')
<section id="loading-screen" class="vh-100">
    <div class="container vh-100 d-flex">
        <div class="row my-auto mx-auto">
            <div class="col-12">
                <div class="spinner">
                    <div class="double-bounce1 bg-warning"></div>
                    <div class="double-bounce2 bg-warning"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="main">
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="d-flex">
                    <div class="me-auto px-2">
                        <h2>{{$todo->todo_name}} detailed steps</h2>
                        @csrf
                    </div>
                    <div class="px-2">
                        <a href="{{ url('todo/') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left-long"></i> back</a>
                    </div>
                </div>
                <div class="card-group card-group-scroll scrollable">
                    <div class="card status-card" id="TODOCard" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <div class="card-body rounded border border-secondary">
                            <h5 class="card-title">
                                <i class="fa-regular fa-circle-dot"></i> Todo
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Steps that waiting to be done goes here.
                            </h6>
                            @foreach($steps as $step)
                                @if($step->step_status=='TODO')
                                    <div class="card step-card mb-3 p-2" id="step{{$step->step_id}}" data-step-id = "{{$step->step_id}}" draggable="true" ondragstart="drag(event)" ondrop="dropChild(event)">
                                        <h5 class="card-title">
                                            {{$step->step_name}}
                                        </h5>
                                        @if($step->step_detail != null)
                                            <h6 class="card-subtitle fw-light fst-italic text-muted">
                                                {{$step->step_detail}}
                                            </h6>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card status-card" id="ONPROGRESSCard" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <div class="card-body rounded border border-secondary">
                            <h5 class="card-title">
                                <i class="fa-regular fa-circle-play text-primary"></i> On progress
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Steps that being done partially goes here.
                            </h6>
                            @foreach($steps as $step)
                                @if($step->step_status=='ON PROGRESS')
                                    <div class="card step-card mb-3 p-2" id="step{{$step->step_id}}" data-step-id = "{{$step->step_id}}" draggable="true" ondragstart="drag(event)" ondrop="dropChild(event)">
                                        <h5 class="card-title">
                                            {{$step->step_name}}
                                        </h5>
                                        @if($step->step_detail != null)
                                            <h6 class="card-subtitle fw-light fst-italic text-muted">
                                                {{$step->step_detail}}
                                            </h6>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card status-card" id="DONECard" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <div class="card-body rounded border border-secondary">
                            <h5 class="card-title">
                                <i class="fa-regular fa-circle-check text-success"></i> Done
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Finished steps goes here.
                            </h6>
                            @foreach($steps as $step)
                                @if($step->step_status=='DONE')
                                    <div class="card step-card mb-3 p-2" id="step{{$step->step_id}}" data-step-id = "{{$step->step_id}}" draggable="true" ondragstart="drag(event)" ondrop="dropChild(event)">
                                        <h5 class="card-title">
                                            {{$step->step_name}}
                                        </h5>
                                        @if($step->step_detail != null)
                                            <h6 class="card-subtitle fw-light fst-italic text-muted">
                                                {{$step->step_detail}}
                                            </h6>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('additionalScript')

{{-- drag and drop script --}}
<script>

    $('#loading-screen').addClass('d-none');
    var step_id;
    var step_status_current;
    var step_status;
    var todo_id = "<?= $todo->todo_id ?>";

    function allowDrop(ev) {
      ev.preventDefault();
    }
    
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
      step_id = ev.target.dataset.stepId;
      step_status_current = ev.target.parentElement.parentElement.id;
    }
    
    function drop(ev) {
        
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        var step_status_box;
        if(ev.target.parentElement.className === "card status-card") {
            step_status_box = ev.target;
        }else if(ev.target.parentElement.className === "card-body rounded border border-secondary"){
            step_status_box = ev.target.parentElement;
        }else{
            step_status_box = ev.target.parentElement.parentElement; 
        }

        step_status_box.appendChild(document.getElementById(data));


        switch (step_status_box.parentElement.id) {
            case "TODOCard":
                step_status = "TODO"
                break;
            case "ONPROGRESSCard":
                step_status = "ON PROGRESS"
                break;
            case "DONECard":
                step_status = "DONE"
                break;
            default:
                step_status = ev.target.parentElement.id;
                break;
        }

        if(step_status_current !== step_status_box.parentElement.id) {
            $('#main').addClass('d-none');
            $('#loading-screen').removeClass('d-none');

            var params = {
                'todo_id':todo_id,
                'step_id':step_id,
                'step_status':step_status
            }
            // const path = "{{ url('/todo/'.$todo->todo_id.'/update-step-status') }}";
            const path = "{{ url('/todo/update-step-status') }}";
            pagePost(path,params);
        }

    }

    function dropChild(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");

        if(ev.target.parentElement.className === "card step-card") {
            ev.target.parentElement.parentElement.appendChild(document.getElementById(data));  
        }
        
    }
</script>
@endsection