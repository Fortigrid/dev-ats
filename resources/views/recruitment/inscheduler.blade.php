@extends('layouts.master')
@section('content')


<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header">Interview Scheduler</div>
                <div class="card-body">
                  @if($errors->any())
					  <div class="alert alert-warning alert-dismissible fade show">
							<button type="button" class="close remove" data-dismiss="alert">&times;</button>
					<strong>Opps Something went wrong!</strong>
					<hr>
						<ul>
						@foreach ($errors->all() as $error)
							<li> {{ $error }} </li>
						@endforeach
						</ul>
					</div>
					
				 @endif
				 <div class="row">
				
				 <div id='calendar'></div>
           
        </div>
				 
				
              </div>
           </div>
        </div>
		
    </div>
	
	
</div><br>
<div class="modal fade" id="ajaxModel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading2">Preview CV</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			
                
				<div class="form-group">
				<label>Event Title</label> <input type="text" value="">
				</div>
				
			
            </div>
        </div>
    </div>
</div>

<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
	   initialView:'dayGridMonth',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
      //$('#ajaxModel2').modal('show');
	  var start=moment(arg.start).format('YYYY-MM-DDThh:mm');
	  //var start= arg.start;
	  alert(start);
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
     
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
	  slotDuration: '00:15:00', 
	  eventDidMount: function(event) { 
   
    var new_description ='<br/><a style="float:right;margin-top:-16px;border:3px solid red;color:white;font-weight:bold;" href="https://www.google.com">'
    + '<strong>Edit</strong>'  + '</a>' + '&nbsp;&nbsp;&nbsp;&nbsp;'
    $('.fc-event-title').append(new_description); 
},
      events:{
			url:  "http://localhost:8000/recruitment/managead/54/eventfeed",
			type: 'POST',
			success: function(data, xhr) {
				
				//console.log('XHR success callback');
			},
			failure: function(xhr) {
				
				//console.error('XHR failure callback');
			}
		}
    });
	
	

    calendar.render();
  });
  
  

</script>
<style>

 
  #calendar {
    width: 1100px;
    margin: 0 auto;
  }

</style>
 

@endsection



