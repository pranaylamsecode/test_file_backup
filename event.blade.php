@extends('frontend.layouts.main')
@section('title') {{'Events'}} @endsection

@push('css')
<style type="text/css">


.event_pagination {
    margin-top: 30px;
    margin-bottom: 30px;
}

.event_pagination p{color:#464646;}

.event_pagination p{margin-top:0;margin-bottom:1rem;}
.event_pagination a{color:#2f708f;text-decoration:none;}
.event_pagination a:hover{color:#265a72;text-decoration:underline;}
.event_pagination svg{vertical-align:middle;}
.event_pagination ::-moz-focus-inner{padding:0;border-style:none;}
.event_pagination .row > *{flex-shrink:0;width:100%;max-width:100%;padding-right:calc(var(--bs-gutter-x) * 0.5);padding-left:calc(var(--bs-gutter-x) * 0.5);margin-top:var(--bs-gutter-y);}
@media (min-width: 768px){
#.event_pagination .col-md-12{flex:0 0 auto;width:100%;}
}
.event_pagination .shadow-sm{box-shadow:0 0.1rem 0.3rem rgba(0, 0, 0, 0.1)!important;}
.event_pagination .border{border:1px solid #dee2e6!important;}
.event_pagination .px-2{padding-right:0.5rem!important;padding-left:0.5rem!important;}
.event_pagination .px-4{padding-right:1.5rem!important;padding-left:1.5rem!important;}
.event_pagination .py-2{padding-top:0.5rem!important;padding-bottom:0.5rem!important;}
.event_pagination .bg-white{--bs-bg-opacity:1;background-color:rgba(var(--bs-white-rgb), var(--bs-bg-opacity))!important;}
.event_pagination .bg-white{background-color:#fff!important;}
.event_pagination .text-sm{font-size:0.875rem!important;}
.event_pagination .text-gray-500{color:#adb5bd!important;}
.event_pagination .text-gray-700{color:#495057!important;}
.event_pagination .text-gray-500{color:#adb5bd;}
.event_pagination .text-gray-700{color:#495057;}
/*! CSS Used from: https://groupbook.getjanhost.dev/public/frontend/css/custom.css */
.event_pagination a:hover{text-decoration:none;}
/*! CSS Used from: Embedded */
.event_pagination *,.event_pagination::after, .event_pagination::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb;}
.event_pagination::after,.event_pagination::before{--tw-content:'';}
.event_pagination a{color:inherit;text-decoration:inherit;}
.event_pagination:-moz-focusring{outline:auto;}
.event_pagination p{margin:0;}
.event_pagination :disabled{cursor:default;}
.event_pagination svg{display:block;vertical-align:middle;}
.event_pagination *,.event_pagination ::before,::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-scroll-snap-strictness:proximity;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;}
.event_pagination .relative{position:relative;}
.event_pagination .z-0{z-index:0;}
.event_pagination .ml-3{margin-left:0.75rem;}
.event_pagination .-ml-px{margin-left:-1px;}
.event_pagination .flex{display:flex;}
.event_pagination .inline-flex{display:inline-flex;}
.event_pagination .hidden{display:none;}
.event_pagination .h-5{height:1.25rem;}
.event_pagination .w-5{width:1.25rem;}
.event_pagination .flex-1{flex:1 1 0%;}
.event_pagination .cursor-default{cursor:default;}
.event_pagination .items-center{align-items:center;}
.event_pagination .justify-between{justify-content:space-between;}
.event_pagination .rounded-md{border-radius:0.375rem;}
.event_pagination .rounded-l-md{border-top-left-radius:0.375rem;border-bottom-left-radius:0.375rem;}
.event_pagination .rounded-r-md{border-top-right-radius:0.375rem;border-bottom-right-radius:0.375rem;}
.event_pagination .border{border-width:1px;}
.event_pagination .border-gray-300{--tw-border-opacity:1;border-color:rgb(209 213 219 / var(--tw-border-opacity));}
.event_pagination .bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));}
.event_pagination .px-2{padding-left:0.5rem;padding-right:0.5rem;}
.event_pagination .px-4{padding-left:1rem;padding-right:1rem;}
.event_pagination .py-2{padding-top:0.5rem;padding-bottom:0.5rem;}
.event_pagination .text-sm{font-size:0.875rem;line-height:1.25rem;}
.event_pagination .font-medium{font-weight:500;}
.event_pagination .leading-5{line-height:1.25rem;}
.event_pagination .text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity));}
.event_pagination .text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity));}
.event_pagination .shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);}
.event_pagination .ring-gray-300{--tw-ring-opacity:1;--tw-ring-color:rgb(209 213 219 / var(--tw-ring-opacity));}
.event_pagination .transition{transition-property:color, background-color, border-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-text-decoration-color, -webkit-backdrop-filter;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-text-decoration-color, -webkit-backdrop-filter;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms;}
.event_pagination .duration-150{transition-duration:150ms;}
.event_pagination .ease-in-out{transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);}
.event_pagination .hover\:text-gray-500:hover{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity));}
.event_pagination .hover\:text-gray-400:hover{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity));}
.event_pagination .focus\:z-10:focus{z-index:10;}
.event_pagination .focus\:border-blue-300:focus{--tw-border-opacity:1;border-color:rgb(147 197 253 / var(--tw-border-opacity));}
.event_pagination .focus\:outline-none:focus{outline:2px solid transparent;outline-offset:2px;}
.event_pagination .focus\:ring:focus{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}
.event_pagination .active\:bg-gray-100:active{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity));}
.event_pagination .active\:text-gray-700:active{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity));}
.event_pagination .active\:text-gray-500:active{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity));}
@media (min-width: 640px){
.event_pagination .sm\:flex{display:flex;}
.event_pagination .sm\:hidden{display:none;}
.event_pagination .sm\:flex-1{flex:1 1 0%;}
.event_pagination .sm\:items-center{align-items:center;}
.event_pagination .sm\:justify-between{justify-content:space-between;}
}
/**/


/*Style for grouping cards */

</style>
@endpush
@section('main-container')

@section('main-container')
  <section class="position-relative pt-6 pb-5 bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="">
            <div class="">
              <h1 class="mb-3 text-white">Upcoming Events</h1>
              <p class="text-white">Find event selected accomodations by event.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CARDS -->
  <section class="pb-6">
    <div class="container">

      <div class="row">
        <div class="col-md-12 event_pagination">
            {{ $events->links() }}
        </div>
      </div>

      <div class="row">
        {{-- @php 
        print_r($events);
        die;
        @endphp
 --}} 
        @if(count($events))
        @foreach($events as $event)
        @php 
              $event_types_arr = explode(',', $event->event_type);        

              $e_types = array();

              foreach ($event_types as $event_type_key => $event_type_value) {
                      if(in_array($event_type_value->id,$event_types_arr))
                          array_push($e_types, $event_type_value);
                      }
                 

              @endphp 
             

        <div class="mb-4 col-sm-6 col-lg-3">
         
            <div class="card h-100 border-0 hover-animate bg-transparent mb-4">
              <a class="position-relative" href="{{url('/event/'.$event->slug)}}">

                <img class="card-img-top team-img img-fluid"  
                src="{{ $event->cover_photo }}" 
                data-old-src="{{ $event->cover_photo }}"  
                alt="{{$event->slug}}" 
                onerror="this.onerror=null;this.src='{{url('public/images/default-image.png')}}';"
                >


            
                  <div class="card-img-overlay-bottom z-index-20">
                    <div class="d-flex text-white text-sm align-items-center">

                      @foreach($e_types as $etype)
                      <span class="badge bg-light text-dark me-2">
                        
                           
                          {{--  @php 
                           
                            $tmp = \App\Models\EventTypes::where('id', '=', $event->event_type)->first();
                            $temp = Illuminate\Support\Str::limit($tmp->name, 230);
                            @endphp

                    
                    
                   
                    {{ ucwords(strtolower($temp) )}} --}}
                       
                       {{ ucwords($etype->name) }}
                      </span>
                      @endforeach
                    </div>
                  </div>
                <div class="tbg-secondary-light"></div>
              </a>
          
            <a class="position-relative" href="{{url('/event/'.$event->slug)}}">
              <div class="card-body team-body text-center">
              <h6 class="card-title">
                @php 

                    $event_name = Illuminate\Support\Str::limit($event->name, 230);
                    @endphp
                    {{ ucwords($event_name) }}
                
              </h6>
             <!-- <p class="card-subtitle text-muted text-xs text-uppercase mb-1">{{ date("M d, Y", strtotime($event->start_date)) }} - {{ date("M d, Y", strtotime($event->end_date)) }} </p>
              <p class="card-subtitle text-muted text-xs text-uppercase">
                @php 

                $event_event_address_city = Illuminate\Support\Str::limit($event->event_address->city, 23);
                $event_event_address_get_state_name = Illuminate\Support\Str::limit($event->event_address->get_state->name, 23);
                @endphp
                {{ ucfirst(strtolower($event_event_address_city) )}},{{ ucfirst(strtolower($event_event_address_get_state_name) )}}

              </p> -->
              </div>
            </a>

          </div>
        </div>
        

      @endforeach


      @else
      <h4>Coming soon.</h4>
      @endif

      </div>


      <div class="row">
        <div class="col-md-12 event_pagination">
            {{ $events->links() }}
        </div>
      </div>

    </div>



    


    {{-- <div class="col-md-12 text-center " style="justify-content: center !important;
    align-items: center !important;
    display: flex;">
              
    </div> --}}

    <!-- Pagination -->
    {{-- <nav aria-label="Page navigation example">
      <ul class="pagination pagination-template d-flex justify-content-center">
        <li class="page-item"><a class="page-link" href="#"> <i class="fa fa-angle-left"></i></a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#"> <i class="fa fa-angle-right"></i></a></li>
      </ul>
    </nav> --}}
  </section>

@endsection