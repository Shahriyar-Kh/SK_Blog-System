<div>
   <div class='mb-3'>
   @if(Session::get('info'))
       <div class="alert alert-info" role="alert">
          {!! Session::get('info') !!}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
       </div>
   </div>
   @endif
   </div>

   <div class='mb-3'>
   @if(Session::get('fail'))
       <div class="alert alert-danger" role="alert">
          {!! Session::get('fail') !!}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
       </div>
   @endif
   </div>

 
   <div class='mb-3'>
       @if(Session::get('success'))
       <div class="alert alert-success" role="alert">
          {!! Session::get('success') !!}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
       </div>
        @endif
        </div>

</div>