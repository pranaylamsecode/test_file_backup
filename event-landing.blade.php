@php


$get_address_latitude ='';

$get_adderess ='';

              $get_address_longitude ='';

$default_hotel_image = url('public/images/default-hotel-image.png');

              @endphp
@extends('frontend.layouts.main')
@section('title') {{'Event '}} | {{ $event->name }} @endsection

@push('css')

<link rel="stylesheet" type="text/css" href="{{ url('public/css/daterangepicker.min.css')}}" />

<style>

#hotels_loader {
    
    position: relative !important;
}

  @media (min-width: 320px) and (max-width: 991px) {
    .event-details-section>div {
      border-bottom: 1px solid #ddd;
    }
  }

  
  @media (min-width: 992px) and (max-width: 1399px) {

    .event-details-section>div:nth-child(1),
    .event-details-section>div:nth-child(2),
    .event-details-section>div:nth-child(3) {
      border-right: 1px solid #ddd;
    }

    .event-details-section>div:nth-child(4) {
      font-size: 12px;
      padding-right: 0 !important;
    }

    .event-details-section>div h5 {
      font-size: 16px;
    }

    .event-details-section>div h3 {
      font-size: 18px;
    }

    .event-details-section {
      margin-left: 0 !important;
      margin-right: 0 !important;
    }

  }

  

  
  @media (min-width: 1400px) {

    .event-details-section>div:nth-child(1),
    .event-details-section>div:nth-child(2),
    .event-details-section>div:nth-child(3) {
      border-right: 1px solid #ddd;
      padding: 0 1rem;
    }

    .event-details-section>div,
    .event-details-section>div:last-child {
      display: flex;
      justify-content: center;
    }

    .event-details-section>div:last-child>div {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
  }
</style>

@endpush

@section('main-container')
<div id="number_of_nights" class="d-none" data_value=""></div>
<!-- NEW LAYOUT ------------------------------------------ -->
<div class="container" style="min-height: 700px;">
  <div class="row">


    <div class="col-lg-12">

      <div>

        <!-- Header section-->
        <section style="padding-top: 80px;" id="event_hero_section">

          <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3" >
              {{ $event->name }}
              @if(Auth::guard('administrator')->check())
         
                 @if($event->event_hosted_by == Auth::guard('administrator')->user()->id)
                    <a href="{{ url('administrator/add-events/'.$event->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                 @endif
              @endif
            </h1>
          </div>

          <!-- Main image -->
          <div class="" style="max-height: 600px; overflow: hidden;">
            <img id="main_image_hide" class="rounded" src="{{ $event->cover_photo }}" alt="{{ $event->name }}" style="width:100% !important; height: auto; background-size:cover;">
            <img id="main_image_hide2" class="rounded d-none" alt="" style="width:100% !important; height: auto; background-size:cover;">
          </div>
        </section> <!-- /header section -->



        <!-- Event details section -->
        <section 
        class="event-details-section row row-cols-2 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 m-3"
        id="event-details-section"
        data-evvent-id="{{ $event->id }}"
         >

          <div class="col-12">
            <div class="my-3 p-3">
            	
              <p class="text-muted mb-1">
              	@if($events->count() >0)

                You have selected:

                @endif
              </p>
              <h3 class="mb-3">
                <span id="current_event_name_hide">{{ $event->name }}</span><span id="current_event_name_hide2" data-event-name=""></span>
              </h3>

              @if(isset($events))
              <select id="event_change" class="form-select form-select-sm mx-auto" aria-label="Select your event">
                @if($events->count() >0)
                @foreach($events as $event_child)

                  @if(isset($event_child->event->name))
                  <option class="text-sm" value="{{$event_child->parent_event_id}}">{{$event_child->event->name }}</option>
                  @else
                  <option class="text-sm" value="{{$event_child->parent_event_id}}">{{$event->name }}</option>
                  @endif

                  @endforeach
                  @else
                  <option value="" selected="selected">Select Event</option>
                @endif
              </select>
              @endif

            </div>
          </div>


          <div class="col-12">
            <div class="my-3 p-3">
              <p class="text-uppercase">
                <strong>Event dates</strong>
              </p>
              <h5 id="show_event_date_hide" class="mb-3 ">
                {{date('F j, Y', strtotime($event->start_date)) }} - <br>
                {{date('F j, Y', strtotime($event->end_date)) }}
              </h5>
              <h5 id="show_event_date_hide2" class="mb-3 d-none">
                <span id="show_event_start_date"></span> - <br>
                <span id="show_event_end_date"></span>
              </h5>
            </div>
          </div>


          <div class="col-12">
            <div class="my-3 p-3">
              <p class="text-uppercase">
                <strong>Event location</strong>
              </p>
              <h5 id="show_event_event_location_hide" 
              data-event-id="{{$event->id}}"
              data-orign-event-address-latitude="{{$event->event_address->latitude}}" data-orign-event-address-longitude="{{$event->event_address->longitude}}"
              data-orign-event-complete-address="{{ ucwords(strtolower($event->event_address->address_line_1)) }}
                {{ ucwords(strtolower($event->event_address->city)) }}, {{ strtoupper($event->event_address->get_state->state_code) }} {{ $event->event_address->postal_code }}"

               class="mb-3 ">
                {{ ucwords(strtolower($event->event_address->address_line_1)) }}<br>
                {{ ucwords(strtolower($event->event_address->city)) }}, {{ strtoupper($event->event_address->get_state->state_code) }} {{ $event->event_address->postal_code }}
              </h5>

              <h5 
              id="show_event_event_location_hide2" 
              data-event-id
              data-orign-event-address-latitude="{{$event->event_address->latitude}}" data-orign-event-address-longitude="{{$event->event_address->longitude}}"

              data-orign-event-complete-address=""

              class="mb-3 d-none">

                <span id="address_line_1"></span><br>
                <span id="address_city"></span>, <span id="get_state"></span> <span id="postal_code"></span>

              </h5>
              <a href="javascript:void(0)" id="showMapModal" class="text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                  <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6" />
                  <line x1="8" y1="2" x2="8" y2="18" />
                  <line x1="16" y1="6" x2="16" y2="22" />
                </svg> View on map
              </a>
            </div>
          </div>


          <div class="col-12">
            <div class="my-3 p-3 align-self-center">

              {{-- <a href="#" class="text-gray-600 mb-2" type="button" data-bs-toggle="modal" data-bs-target="#eventDocsModal"> --}}

              <a href="javascript:void(0)" class="text-gray-600 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                  <circle cx="12" cy="12" r="10" />
                  <polyline points="12 6 12 12 16 14" />
                </svg> Download event documents
              </a>

              {{-- <a href="#" class="text-gray-600 mb-2" type="button" data-bs-toggle="modal" data-bs-target="#contactsModal"> --}}
              <a href="javascript:void(0)" class="text-gray-600 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                  <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg> Contact event organizer
              </a>

              <div>
                <input type="text" id="copyTarget" class="d-none" value="{{ url('/event/'.$event->slug) }}">
                <a type="button" id="copyButton" class="text-gray-600 mb-2" data-event-url="{{ url('/event/'.$event->slug) }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                  </svg> Copy event url
                </a>
                <div class="alert alert-success mt-4 d-none" role="alert" id="copy_success">
                  Event URL copied!
                </div>
              </div>

            </div>
          </div>


        </section>
        <!-- /end event details section -->




        <!-- NEW SEARCH---------------------- -->
        <div class="mt-6 bg-gray-200 py-1 px-2 rounded" id="search-bar">

          <form id="#" method="get" action="{{url('destinations')}}" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="city_code" id="city_code">
            <input type="hidden" name="city_id" id="city_id">
            <input type="hidden" name="_cache" value="clear">

            <div class="row row-cols-5 g-2 pt-1">
              

              <div class="col-12 col-md-4 col-lg-4 ">
                <div class="form-floating">

                   <input type="text" class="form-control form-control-sm ui-autocomplete-input" name="location" id="front-search-field" placeholder="Add location" value="<?php if(!empty($city)){
                    echo $city; } ?>"  >
                  
                  <label for="front-search-field" class="text-sm">Where are you going?</label>
                </div>
              </div>

              <div class="col-6 col-md-2 col-lg-2 mb-1">
                <div class="form-floating datepicker-container datepicker-container-left">
                  <input type="text" class="form-control form-control-sm" name="checkin" id="check-in" placeholder="Check-in" value="{{ $checkin }}" readonly="readonly">
                  <label for="check-in" class="text-sm">Check-in</label>
                </div>
              </div>


              <div class="col-6 col-md-2 col-lg-2 mb-1">
                <div class="form-floating">
                  <input type="text" class="form-control form-control-sm" name="checkout" id="check-out" placeholder="Check-out" value="{{ $checkout }}" readonly="readonly">
                  <label for="check-out" class="text-sm">Check-out</label>
                </div>
              </div>

              <div class="col-12 col-md-2 col-lg-2 mb-1">
                <div class="form-floating">
                  <input type="number" class="form-control form-control-sm" id="guests" name="guests" placeholder="Add guests" value="1" required="required" min="1">
                  <label for="guests" class="text-sm">Guests</label>
                </div>
              </div>

              <div class="col-12 col-md-2 col-lg-2 mb-2">
                <button class="btn btn-dark h-100 w-100" type="submit">
                  Search
                </button>
              </div>

            </div>
          </form>
        </div>
        <!-- /NEW SEARCH---------------------- -->


        <!-- Hotel results -->

        <div class="my-5 mx-auto">
          <div class="row mb-3 text-center">
            <div id="total_hotels" class="d-none">
              <strong id="selected_text"> {{ucwords($show_event_by)}} </strong>
              <span class="text-muted d-none" id="event_hotels_counter_container">  
                | Showing <span id="show_all_load_hotel">{{$event_hotels->count() }}</span> results 
              </span>
            </div>
            <div class="form-check  mx-auto d-none" style="max-width:260px;">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
              <label class="form-check-label text-sm" for="flexCheckDefault">
                Show rates with taxes and all fees
              </label>
            </div>
          </div>
        </div>

        @php
        

        $get_address_line_1 = '';
        $get_address_city = '';
        $get_address_status = '';
        $get_address_postal_code = '';

        @endphp
        @if($show_event_by !== 'city')
        {{-- by property id  --}}
        @if($event_hotels->count()>0)



        

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3 mb-5 mx-auto d-none" id="hotels">
          @foreach($event_hotels as $eh)

          @php

          $get_hotel_id = $eh->hotel_id;

         $get_propertie_address = \App\Models\PropertyAddress::where('property_id','=',$get_hotel_id)->with('get_state')->get();


              
              $get_address_line_1 = '';
              foreach($get_propertie_address as $gpd)
              {
              if(isset($gpd->address_line_1))
              {

              if(\App\Http\Helpers\Common::is_Json($gpd->address_line_1)){

                $arr = json_decode($gpd->address_line_1);



                $arrCount = count($arr) -1;


                $get_address_line_1 = '';

                foreach ($arr as $key => $value) {


                  if($arrCount != $key){
                    $get_address_line_1 .= $value.' ';
                  }else{
                    $get_address_line_1 .= $value;
                  }
                }



              }else{

                $get_address_line_1 .= $gpd->address_line_1;

              }

              }else{
                $get_address_line_1 .= '';
              }

              if(isset( $gpd->city))
              {
              $get_address_city = $gpd->city;

              }else{
              $get_address_city = '';

              }

              if(isset( $gpd->latitude))
              {
              $get_address_latitude = $gpd->latitude;

              }else{
              $get_address_latitude = '';

              }

              if(isset( $gpd->longitude))
              {
              $get_address_longitude = $gpd->longitude;

              }else{
              $get_address_longitude = '';

              }



              if(isset($gpd->state))
              {
                if($gpd->get_state != null){
                  $get_address_status = $gpd->get_state->state_code;                
                }else{
                  $get_address_status = '';              
                }
                

              }else {

              $get_address_status = '';
              }

              if(isset($gpd->country))
              {
              $get_address_country = $gpd->country;
              }else {
              $get_address_country = '';
              }

              if(isset($gpd->postal_code))
              {
              $get_address_postal_code = $gpd->postal_code;

              }else {
              $get_address_postal_code = '';
              }

              }

              $complete_address ='';

              if(!empty($get_address_line_1)){

                $complete_address .= ucwords(strtolower($get_address_line_1)).' ';

              }

              if(!empty($get_address_city)){
                $complete_address .= ucwords(strtolower($get_address_city)).', ';
              }

              if(!empty($get_address_status)){

                $complete_address .= strtoupper($get_address_status).', ';

              }

              if(!empty($get_address_postal_code)){

                $complete_address .= ' '.$get_address_postal_code;

              }

              

              $address ='';

              if($complete_address ==""){
                $address = '';
              }else{
                $address = $complete_address;
              }

          $get_address_country_change = $get_address_postal_code;




          $orign_lat_long = $event->event_address->latitude.','.$event->event_address->longitude;
          $destination_lat_long = $get_address_latitude.','.$get_address_longitude;
          if(isset($destination_lat_long) && !empty($destination_lat_long) )
          {
          $origin = urlencode($orign_lat_long);
          $destination = urlencode($destination_lat_long);

          $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destination&key=AIzaSyCMuRZL-cOaDyYNQAj4g0SrdTVhsNq9N9I";

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

          curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $response = curl_exec($ch);
          curl_close($ch);
          $response_a = json_decode($response, true);

          if(isset($response_a['rows'][0]['elements'][0]['distance']['text']))
          {
          $get_response_integer = $response_a['rows'][0]['elements'][0]['distance']['text'];
          }else{
          $get_response_integer = 0;
          }


          $get_distance_round = (int)$get_response_integer / 1.609;
          $get_distance_real = round($get_distance_round,2);
          if(!empty($get_distance_real) && $get_distance_real == 0)
          {
          $get_distance = $get_distance_real;
          }
          }


          @endphp
          @if(isset($eh->hotel))




          <div class="single_hotel" data-hotel-id="{{ $eh->hotel->id }}" data-hotel_code="{{ $eh->hotel->hotelId }}" data-event-id="{{ $event->id }}" is_success="false" data-hotel_import_url="{{ url('/administrator/add-properties-amadeus/'.$eh->hotel->hotelId.'/edit') }}" data-hotel_edit_url="{{ url('/administrator/add-properties/'.$eh->hotel->id.'/edit') }}">
            <div class="border card shadow-sm">
              <div class="row g-0">
                <div class="col-md-4" style="min-height:230px; max-height:230px !important; overflow:hidden !important;">
                  <img 
                  src="{{ $eh->hotel->cover_photo }}" 
                  class="img-fluid rounded-start" 
                  data-db-image-url ="{{ $eh->hotel->cover_photo }}"
                  onerror="this.onerror=null;this.src='{{$default_hotel_image}}';"
                  alt="{!! ucwords(strtolower($eh->hotel->name)) !!}" 
                  style="min-height:230px; overflow:hidden; object-fit:cover;">
                </div>
                <div class="col-md-8">
                  <div class="card-body">

                    <h5 class="card-title mb-0">
                      {!! ucwords($eh->hotel->name) !!}
                    </h5>

                    <p class="text-sm mb-4 address">
                      {{$address}}
                    </p>

                    <div class="flex-fill bd-highlight price_area mb-4 d-none">
                      <p class="h4 text-primary price">
                        From
                        <span class="currency_symbol">$</span>
                        <span class="room_price"></span>
                        <span class="text-sm">/night</span>
                      </p>

                      <!-- <small>
                        <span class="currency_symbol">$</span>
                        <span class="total_price"> </span>
                        for
                        <span class="number_of_nights"></span>
                        nights
                      </small> -->
                    </div>


                    @if(isset($get_distance))
                    <p class="text-sm mb-4">
                      <span class="badge bg-gray">{{$get_distance}} miles</span> from event
                    </p>
                    @endif

                    <div class="price_loader text-left mb-4"><i class="fas fa-spinner fa-spin"></i> Loading Price</div>

                    <a href="{{ url('/hotels/'.$eh->hotel->slug) }}" class="btn btn-outline-dark stretched-link">
                      View Rooms
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div> <br>

         
          @endif
          @endforeach

        </div>

        <div class="my-5 mx-auto text-center d-none" id="hotels_loader">
          <i class="fa fa-spinner fa-spin" style="font-size:64px;"></i>
        </div>

           <div class="alert alert-danger d-none" role="alert" id="hotels_not_found_error">
            There are no hotels registered with this event. Please <a href="/contact" class="alert-link">contact us</a> if you feel you've reached this in error.
          </div>

        @else
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3 mb-5 mx-auto d-none" id="hotels">
            
          </div>
          <div id="hotels_loader" class="my-5 mx-auto text-center d-none">
            <i class="fa fa-spinner fa-spin" style="font-size:64px;"></i>
          </div>
          <div class="alert alert-danger d-none" role="alert" id="hotels_not_found_error">
            There are no hotels registered with this event. Please <a href="/contact" class="alert-link">contact us</a> if you feel you've reached this in error.
          </div>
        @endif


        @else
        <div>
          {{-- city hotels start  --}}

          <div class="results row">





            

          	<div class="my-5 mx-auto text-center d-none" id="hotels_loader">
              <i class="fa fa-spinner fa-spin" style="font-size:64px;"></i>
            </div>

            <div class="alert alert-danger d-none" role="alert" id="hotels_not_found_error">
                There are no hotels registered with this event. Please <a href="/contact" class="alert-link">contact us</a> if you feel you've reached this in error.
            </div>

            @if(count($event_hotels))            

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3 mb-5 mx-auto" id="hotels">
              @foreach($event_hotels as $property)

              @php

              

              $get_hotel_id = $property->id;

               $get_propertie_address = \App\Models\PropertyAddress::where('property_id','=',$get_hotel_id)->with('get_state')->get();


              
              $get_address_line_1 = '';
              foreach($get_propertie_address as $gpd)
              {
              if(isset($gpd->address_line_1))
              {

              if(\App\Http\Helpers\Common::is_Json($gpd->address_line_1)){

                $arr = json_decode($gpd->address_line_1);



                $arrCount = count($arr) -1;


                $get_address_line_1 = '';

                foreach ($arr as $key => $value) {


                  if($arrCount != $key){
                    $get_address_line_1 .= $value.' ';
                  }else{
                    $get_address_line_1 .= $value;
                  }
                }



              }else{

                $get_address_line_1 .= $gpd->address_line_1;

              }

              }else{
                $get_address_line_1 .= '';
              }

              if(isset( $gpd->city))
              {
              $get_address_city = $gpd->city;

              }else{
              $get_address_city = '';

              }

              if(isset( $gpd->latitude))
              {
              $get_address_latitude = $gpd->latitude;

              }else{
              $get_address_latitude = '';

              }

              if(isset( $gpd->longitude))
              {
              $get_address_longitude = $gpd->longitude;

              }else{
              $get_address_longitude = '';

              }



              if(isset($gpd->state))
              {
                if($gpd->get_state != null){
                  $get_address_status = $gpd->get_state->state_code;                
                }else{
                  $get_address_status = '';              
                }
                

              }else {

              $get_address_status = '';
              }

              if(isset($gpd->country))
              {
              $get_address_country = $gpd->country;
              }else {
              $get_address_country = '';
              }

              if(isset($gpd->postal_code))
              {
              $get_address_postal_code = $gpd->postal_code;

              }else {
              $get_address_postal_code = '';
              }

              }

              $complete_address ='';

              if(!empty($get_address_line_1)){

                $complete_address .= ucwords(strtolower($get_address_line_1)).' ';

              }

              if(!empty($get_address_city)){
                $complete_address .= ucwords(strtolower($get_address_city)).', ';
              }

              if(!empty($get_address_status)){

                $complete_address .= strtoupper($get_address_status).', ';

              }

              if(!empty($get_address_postal_code)){

                $complete_address .= ' '.$get_address_postal_code;

              }

              

              $address ='';

              if($complete_address ==""){
                $address = '';
              }else{
                $address = $complete_address;
              }

              $get_address_country_change = $get_address_postal_code;


              

              $orign_lat_long = $event->event_address->latitude.','.$event->event_address->longitude;
              $destination_lat_long = $get_address_latitude.','.$get_address_longitude;
              if(isset($destination_lat_long) && !empty($destination_lat_long) )
              {
              $origin = urlencode($orign_lat_long);
              $destination = urlencode($destination_lat_long);

              $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destination&key=AIzaSyCMuRZL-cOaDyYNQAj4g0SrdTVhsNq9N9I";

              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

              curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
              $response = curl_exec($ch);
              curl_close($ch);
              $response_a = json_decode($response, true);

              if(isset($response_a['rows'][0]['elements'][0]['distance']['text']))
              {
              $get_response_integer = $response_a['rows'][0]['elements'][0]['distance']['text'];
              }else{
              $get_response_integer = 1;
              }


              $get_distance_round = (int)$get_response_integer / 1.609;
              $get_distance_real = round($get_distance_round,2);
              if(!empty($get_distance_real) && $get_distance_real == 0)
              {
              $get_distance = $get_distance_real;
              }
              }


              @endphp

              {{-- new card adding start  --}}

              <div class="row single_hotel" data-hotel-id="{{ $property->id }}" data-hotel_code="{{ $property->hotelId }}" data-event-id="{{ $event->id }}" is_success="false" data-hotel_import_url="{{ url('/administrator/add-properties-amadeus/'.$property->hotelId.'/edit') }}" data-hotel_edit_url="{{ url('/administrator/add-properties/'.$property->id.'/edit') }}">
                <div class="border card shadow-sm">
                  <div class="row g-0">
                    <div class="col-md-4" style="min-height:230px; max-height:230px; overflow:hidden;">

                      @php
                      $property_name = $property->name;
                      @endphp
                      <img 
                      src="{{ $property->cover_photo }}" 
                      onerror="this.onerror=null;this.src='{{$default_hotel_image}}';"
                      class="img-fluid rounded-start" 
                      data-db-image-url ="{{ $property->cover_photo }}"
                      alt="{!! ucwords(strtolower($property_name)) !!}" 
                      style="min-height:230px; overflow:hidden; object-fit:cover;">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title mb-0">
                          {!! ucwords(strtolower($property_name)) !!}
                        </h5>
                        <div class="price_loader text-left mb-4"><i class="fas fa-spinner fa-spin"></i> Loading Price</div>
                        <div class="flex-fill bd-highlight price_area mb-4 d-none">
                          <small>
                            From
                            <del>
                              <span class="currency_symbol">$</span>
                              <span class="compare_price"> </span>
                            </del>
                            <br>

                            <span class="h4 text-primary price">
                              <span class="currency_symbol">$</span>
                              <span class="room_price"> </span>
                            </span> per night</small>

                          <br>

                          <small class="d-none">
                            <span class="currency_symbol">$</span>
                            <span class="total_price"> </span>
                            for
                            <span class="number_of_nights"></span>
                            nights
                          </small>

                        </div>

                        <p class="text-sm mb-1">
                          {{$address}}
                        </p>
                        @if(isset($get_distance))
                        <p class="text-sm mb-4">
                          <span class="badge bg-gray">{{$get_distance}} miles</span> from event
                        </p>
                        @endif
                        <a href="{{ url('/hotels/'.$property->slug) }}" class="btn btn-outline-dark stretched-link">
                          View Rooms
                        </a>
                      </div>
                    </div>
                  </div>

                </div>
              </div> <br>

              {{-- new card adding start end  --}}
              @endforeach

              </div>

              @else
              <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3 mb-5 mx-auto d-none" id="hotels"></div>
              
              @endif


              <div class="my-5 mx-auto text-center d-none" id="hotels_loader">
                <i class="fa fa-spinner fa-spin" style="font-size:64px;"></i>
              </div>
              <div class="alert alert-danger d-none" role="alert" id="hotels_not_found_error">
                There are no hotels registered with this event. Please <a href="/contact" class="alert-link">contact us</a> if you feel you've reached this in error.
              </div>
            

            {{-- city  hotels end  --}}
          </div>
        </div>
        @endif


        <!-- CTA banner -->
        <div class="container my-5" id="cta_section">
          <div class="row border p-3 rounded">
            <div class="col-12 col-md-8">
              <h3 class="h-4">
                Can't find what you're looking for?
              </h3>
            </div>
            <div class="col-12 col-md-4">
              <a href="/request-a-property" class="btn btn-outline-dark">
                Request a property
              </a>
            </div>
          </div>
        </div>



      </div>
    </div> <!-- /col -->
  </div> <!-- /row -->
</div>



<!-- Event documents modal -->
<div class="modal fade" id="eventDocsModal" tabindex="-1" aria-labelledby="eventDocsLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventDocsLabel">
          Event Documents
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">

          @if(count($event->event_documents)>0)
          <small class="mb-3 ">
            <strong class="">Event documents:</strong>
            <ul style="padding-left: 1rem;">
              @foreach($event->event_documents as $event_document)
              @php
              $words = $event_document->document;
              $words = preg_replace('/\d+/u', '', $words);

              $output = str_replace('_', ' ', $words);

              $output1 = str_replace('.', ' ', $output);

              $output2 = str_replace('pdf', ' ', $output1);
              @endphp
              <li>
                <a target="_blank" href="{{ url('public/pdf/'.$event->id.'/'.$event_document->document) }}">{{ $output2 }}</a>
              </li>
              @endforeach
            </ul>
            @endif
          </small>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contacts modal -->
<div class="modal fade" id="contactsModal" tabindex="-1" aria-labelledby="contactsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactsModalLabel">
          Contacts
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">

          <small class="mb-3 ">
            <strong class="">Event contacts:</strong>

            <ul class="list-unstyled mb-4 mt-1">

              @if(isset($event->event_contact->phone))
              <li class="mb-2">
                <a class="text-sm text-decoration-none" href="tel:{{ $event->event_contact->phone }}">
                  <i class="fa fa-phone me-1"></i>
                  {{ $event->event_contact->phone }}
                </a>
              </li>
              @endif

              @if(isset($event->event_contact->email ))
              <li class="mb-2">
                <a class=" text-sm text-decoration-none" href="mailto:{{ $event->event_contact->email }}">
                  <i class="fa fa-envelope me-1"></i>
                  {{ $event->event_contact->email }}
                </a>
              </li>
              @endif

              @if(isset($event->event_contact->website))
              @php
              $get_site_name = str_replace('https://', '', $event->event_contact->website);

              @endphp
              <li class="mb-2">
                <a class="text-sm text-decoration-none" rel="nofollow" href="{{ $event->event_contact->website }}" target="_blank">
                  <i class="fa fa-globe me-1"></i>
                  {{ str_replace('/', '', $get_site_name) }}
                </a>
              </li>
              @endif

              @if(isset($event->event_contact->facebook ))
              @php
              $str_get_fb = str_replace('https://www.facebook.com/', '@', $event->event_contact->facebook );
              @endphp
              <li class="mb-2">
                <a class="text-sm text-decoration-none" href="{{ $event->event_contact->facebook }}" target="_blank">
                  <i class="fab fa-facebook me-1"></i>
                  {{ str_replace('/', ' ', $str_get_fb ) }}
                </a>
              </li>
              @endif
              @if(isset($event->envet_contact->twitter))

              @php
              $str_get_twitter = str_replace('https://www.twitter.com/', '@', $event->envet_contact->twitter );
              @endphp
              <li class="mb-2">
                <a class="text-sm text-decoration-none" href="{{ $event->event_contact->twitter }}" target="_blank">
                  <i class="fab fa-twitter me-1"></i>
                  {{ str_replace('/', ' ', $str_get_twitter ) }}
                </a>
              </li>
              @endif

              @if(isset( $event->event_contact->instagram ))
              @php
              $str_get_int = str_replace('https://www.instagram.com/', '@', $event->event_contact->instagram );
              @endphp
              <li class="mb-2">
                <a class="text-sm text-decoration-none" href="{{ $event->event_contact->instagram }}" target="_blank">
                  <i class="fab fa-instagram me-1"></i>
                  {{ str_replace('/', ' ', $str_get_int ) }}
                </a>
              </li>
              @endif

            </ul>
          </small>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Map modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapModalLabel">
          {{ $event->event_address->address_line_1 }}, {{ $event->event_address->get_state->state_code }}, {{ $event->event_address->postal_code }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">

          <div class="maps" id="maps">
            <div  class="map" id="detailMap_{{$event->id}}" style="min-height: 80vh; width: 100% !important; outline: 1px solid black;"></div>
            
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END THE NEW LAYOUT HERE======================= -->
<!-- /NEW LAYOUT ------------------------------------------ -->





<!-- MAIN COLUMN -->
@push('scripts')
<script type="text/javascript">
  var show_event_by = "{{ $event->show_event_by }}";
</script>
@endpush

@if(isset($amadeus_city_codes_id))
@push('scripts')

<script type="text/javascript">
  $(document).ready(function() {



    var city_code = "{{$amadeus_city_code}}";

    var city_id = "{{$amadeus_city_codes_id}}";

    localStorage.setItem("city_code", city_code);
    localStorage.setItem("city_id", city_id);

    jQuery("#city_code").val(city_code);

    jQuery("#city_id").val(city_id);


  });
</script>
@endpush
@endif

@push('scripts')


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"> </script>


<script type="text/javascript" src="{{ url('public/frontend/js/longbill/jquery.daterangepicker.js') }}"></script>


<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

<script src="{{ url('public/js/map-layers.js') }}"> </script>
<script src="{{ url('public/js/map-detail.js') }}"></script>



<script type="text/javascript">
  var GET_CURRENCY_SYMBOL_URL = "{{ url('get-currency-symbol') }}";
</script>





<script type="text/javascript">
  $(document).ready(function() {

    var html_hotel_counter = jQuery(".single_hotel").length;

    var html_response_counter = 1;






    jQuery("#copyButton").on("click", function() {



      var value = $(this).attr('data-event-url');
      var $temp = jQuery("<input>");
      jQuery("body").append($temp);
      $temp.val(value).select();
      document.execCommand("copy");
      $temp.remove();

      jQuery("#copy_success").removeClass('d-none');

      setTimeout(function() {

        jQuery("#copy_success").addClass('d-none');

      }, 3000);



    });


    jQuery(".price_loader").removeClass('d-none');

    if(jQuery("#event_change").val() == ""){

    	console.log('Running From 1');

		jQuery("#hotels").addClass('d-none');



		jQuery('#total_hotels').addClass('d-none');


      if(show_event_by=="city"){
        console.log("Loading from ashasghahdf 1");


        var event_id = jQuery("#show_event_event_location_hide").attr("data-event-id");

        $.ajax({



      url: "{{ url('master-event-data-by-event-id') }}/" + event_id,

      data: {
        event_id:event_id,
        guest_count: jQuery("#guests").val(),
        checkin: jQuery("#check-in").val(),
        checkout:jQuery("#check-out").val()

      },

      type: 'post',
      headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      },



      success: function(result) {

        console.log(result);

        jQuery('#show_event_event_location_hide').attr('data-event-id',result.event_id);



        jQuery('#selected_text').text(' Accomodations In The '+result.city+' Area ');

        jQuery("#show_event_event_location_hide").attr('data-orign-event-complete-address',result.event_address);


        jQuery("#show_event_event_location_hide").attr('data-orign-event-address-latitude',result.latitude);

        jQuery("#show_event_event_location_hide").attr('data-orign-event-address-longitude',result.longitude);

        

        jQuery('#check-in').val(result.original_start_date);
        jQuery('#check-out').val(result.original_end_date);
        jQuery('#front-search-field').val(result.city);


        jQuery('#show_event_start_date').html(result.start_date);
        jQuery('#show_event_end_date').html(result.end_date);

        jQuery('#address_line_1').html(result.address_line_1);
        jQuery('#address_city').html(result.city);
        jQuery('#get_state').html(result.get_state);
        jQuery('#postal_code').html(result.postal_code);

        jQuery('#current_event_name_hide2').html(result.name);

        jQuery('#current_event_name_hide2').attr('data-event-name',result.name);

        jQuery('#main_image_hide2').attr('src', result.image_url);

        localStorage.setItem("city_code", result.city_code);
        localStorage.setItem("city_id", result.city_id);

        jQuery("#city_code").val(result.city_code);

        jQuery("#city_id").val(result.city_id);

        jQuery("#hotels").html(result.hotels);

        var html_hotel_counter = jQuery("body .single_hotel").length;

        var html_response_counter = 1;

        jQuery('.single_hotel').removeClass('d-none');

        var checkin = jQuery("#check-in").val();
        var checkout = jQuery("#check-out").val();

        var number_of_guest = jQuery("#guests").val();

        var number_of_rooms = jQuery("#rooms").val();




        jQuery(".price_loader").removeClass('d-none');



        var event_id = jQuery("#show_event_event_location_hide2").attr("data-event-id");

        var new_map_id = "detailMap_"+result.event_id;

        jQuery("body .map").addClass('d-none');

        jQuery("body .map").removeClass('active-map');

        $('#maps').append('<div id="'+new_map_id+'" class="map" style="min-height: 80vh; width: 100% !important; outline: 1px solid black;" ></div>');  

        

        var lat = jQuery("#show_event_event_location_hide2").attr("data-orign-event-address-latitude");

        var long = jQuery("#show_event_event_location_hide2").attr("data-orign-event-address-longitude");

        var event_name = jQuery("#current_event_name_hide2").attr("data-event-name");

        var event_address = jQuery("#show_event_event_location_hide2").attr("data-orign-event-complete-address");


        

        jQuery("#mapModalLabel").text(event_address);

        if(jQuery(new_map_id).html() == ""){



              var map = L.map(new_map_id).setView([lat, long], 13);

              L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
              }).addTo(map);

              L.marker([lat, long]).addTo(map)
                  .bindPopup('<b>'+event_name+'</b> <br> '+event_address);

                  jQuery("#"+new_map_id).addClass("active-map");
                  jQuery("#"+new_map_id).removeClass('d-none');

                  setTimeout(function() {
              
                    map.invalidateSize();
                  }, 600);

                  jQuery('#mapModal').on('show.bs.modal', function(){



                    setTimeout(function() {
                
                      map.invalidateSize();
                    }, 600);
            

            
                  }); 
    
        }

        
        


        /*get price again start */

        if(result.hotels != ""){

          jQuery(document).trigger("hotels_loaded");

          jQuery('body .single_hotel').each(function() {


          console.log("Running Change  Each 1");

          var currentElement = $(this);

          var cTarget = jQuery(this).find(".currencySymbol");

          var is_success = currentElement.attr("is_success");

          var hotelCode = currentElement.attr("data-hotel_code");

          var chainCode = hotelCode.substring(0, 2);

          var cityCode = hotelCode.substring(2, 5);

          currentElement.find(".price_area").addClass('d-none');

          currentElement.find(".price_area").addClass('d-none');




          jQuery.ajax({
            type: 'GET',
            url: "{{ url('get-soap-amadeus-hotel-rooms')}}",
            data: {
              monoproperty: true,
              hotelcode: hotelCode,
              chainCode: chainCode,
              cityCode: cityCode,
              checkin: checkin,
              checkout: checkout,
              guest_count: number_of_guest,
              rooms_count: number_of_rooms,
              endTr: "true"

            },

            success: function(response) {


              if (response.hasOwnProperty('rooms')) {




                var number_of_nights = response.number_of_nights;
                jQuery("#number_of_nights").attr('data_value', number_of_nights);


                var TotalRooms = response.rooms.RoomStay.length;

                var rate_plan_upcharge = response.rate_plan_upcharge;

                if (TotalRooms > 0) {




                  var Room = getSortedFirstRoom(response.rooms.RoomStay, rate_plan_upcharge);

                  if (Room.Total.CurrencyCode == "USD") {




                    var totalRoomPrice = parseFloat(Room.RoomRates.RoomRate.Total.AmountAfterTax);

                    var comparePrice = parseFloat(totalRoomPrice) + parseFloat(20);

                    var perDayRoomPrice = totalRoomPrice / number_of_nights;


                    currentElement.addClass('hotelWithPrice');

                    currentElement.find(".price_area").attr("data_price", perDayRoomPrice.toFixed(2));

                    currentElement.find(".price_area").find(".compare_price").html(comparePrice.toFixed(2));


                    currentElement.find(".price_area").find(".room_price").html(perDayRoomPrice.toFixed(2));

                    currentElement.find(".price_area").find(".total_price").html(totalRoomPrice.toFixed(2));

                    currentElement.find(".price_area").find(".number_of_nights").html(number_of_nights);

                    currentElement.find(".price_area").removeClass('d-none');

                    currentElement.find(".price_loader").addClass('d-none');


                  } else {

                    var currency_conversions = response.CurrencyConversions;

                    var currency_conversions_string = JSON.stringify(currency_conversions);
                    var currency_code = currency_conversions.SourceCurrencyCode;

                    var requested_currency_code = currency_conversions.RequestedCurrencyCode;

                    var room_price = Room.Total.AmountAfterTax;
                    var per_day_price = Room.Total.AmountAfterTax;
                    var gbk_rate = Room.Total.AmountAfterTax;
                    var prc_from_api = Room.Total.AmountAfterTax;

                    jQuery.ajax({
                      url: GET_CURRENCY_SYMBOL_URL,
                      type: "POST",
                      data: {
                        
                        currency: currency_code,
                        requested_currency_code: requested_currency_code,
                        currency_conversions: currency_conversions_string,
                        room_price: room_price,
                        per_day_price: per_day_price,
                        gbk_rate: gbk_rate,
                        prc_from_api: prc_from_api
                      },
                      headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(response, textStatus, jqXHR) {

                        cTarget.html(response.symbol);

                        if (response.is_converted) {

                          console.log('currentElement', currentElement);

                          currentElement.addClass('hotelWithPrice');

                          currentElement.attr("room-price", response.room_price);

                          currentElement.attr("prc-from-api", response.prc_from_api);

                          currentElement.attr("gbk_rate", response.gbk_rate);

                          currentElement.attr("per_day_price", response.per_day_price);

                          currentElement.attr("data-is_currency_converted", "true");



                          var no_of_nights = parseInt(jQuery("#number_of_nights").attr('data_value'));

                          currentElement.find(".price_area").find(".number_of_nights").html(no_of_nights);

                          var calculated_price = response.room_price / no_of_nights;

                          var compare_price = parseFloat(calculated_price) + parseInt(20);

                          currentElement.find(".compare_price").html(compare_price);




                          currentElement.find(".currency_symbol").html(response.symbol);

                          currentElement.find(".price_value").html(calculated_price.toFixed(2));

                          currentElement.find(".room_price").html(calculated_price);

                          currentElement.find(".total_price").html(response.room_price);



                          currentElement.find(".price_loader").addClass('d-none');


                          currentElement.find(".price_area").removeClass('d-none');



                        }



                      },
                      error: function(jqXHR, textStatus, errorThrown) {

                        console.log(errorThrown);

                      }
                    });
                  }






                }

              } else if (response.hasOwnProperty('error')) {

                var ErrorCode = response.error;

                if (ErrorCode) {



                  currentElement.find(".price_loader").addClass('d-none');


                  /*currentElement.closest('.single_hotel').addClass('d-none');*/

                  currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');

                } else {



                  getHotelPriceAgain(hotelCode, currentElement);

                  currentElement.find(".price_loader").addClass('d-none');



                }

                currentElement.find(".price_loader").addClass('d-none');

                /*currentElement.closest('.single_hotel').addClass('d-none');*/

                currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


              } else {




                getHotelPriceAgain(hotelCode, currentElement);

                currentElement.find(".price_loader").addClass('d-none');




                /*currentElement.closest('.single_hotel').addClass('d-none');*/

                currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


              }

              currentElement.find(".price_loader").addClass('d-none');

              

              if(html_hotel_counter === html_response_counter){
                jQuery(document).trigger("hotel_prices_loaded");
              }else{
                $('#hotels_loader').removeClass('d-none');
              }

              html_response_counter++;



            }
          });



        });

        }else{


          jQuery(document).trigger("hotels_not_loaded");

          

        }

        








        /*get price again end*/




      },

      error: function(request, error) {

      }

    
        })

      }else if(show_event_by=="hotels"){

        console.log("Loading from alksjakhskja 2");

        jQuery(document).trigger("hotels_loaded");

        jQuery('.single_hotel').each(function() {


      var currentElement = $(this);

      var cTarget = jQuery(this).find(".currencySymbol");

      var number_of_guest = 1;

      var number_of_rooms = 1;

      var checkin = jQuery("#check-in").val();
      var checkout = jQuery("#check-out").val();

      var is_success = currentElement.attr("is_success");

      var hotelCode = currentElement.attr("data-hotel_code");

      var chainCode = hotelCode.substring(0, 2);

      var cityCode = hotelCode.substring(2, 5);


      $('#hotels_loader').removeClass('d-none');




      jQuery.ajax({
        type: 'GET',
        url: "{{ url('get-soap-amadeus-hotel-rooms')}}",
        data: {
          monoproperty: true,
          hotelcode: hotelCode,
          chainCode: chainCode,
          cityCode: cityCode,
          checkin: checkin,
          checkout: checkout,
          guest_count: number_of_guest,
          rooms_count: number_of_rooms,
          endTr: "true"

        },

        success: function(response) {


          if (response.hasOwnProperty('rooms')) {




            var number_of_nights = response.number_of_nights;

            jQuery("#number_of_nights").attr('data_value', number_of_nights);


            var TotalRooms = response.rooms.RoomStay.length;

            var rate_plan_upcharge = response.rate_plan_upcharge;

            if (TotalRooms > 0) {




              var Room = getSortedFirstRoom(response.rooms.RoomStay, rate_plan_upcharge);



              var rate_plan_codes_from_db = response.rate_plan_upcharge;


              var RPCode = Room.RatePlans.RatePlan.RatePlanCode;

              var Total = Room.Total;



              if (Room.Total.CurrencyCode == "USD") {


                let total_percent = 0;
                let percent_added = 0;
                let percent_to_remove = 0;
                let is_upcharged = false;

                let show_by_rate_plan_code = '';

                if (rate_plan_codes_from_db.length > 0) {



                  for (var i = 0; i < rate_plan_codes_from_db.length; i++) {

                    show_by_rate_plan_code = "show_by_rate_plan_code_false";


                    var rate_plan_code_db = rate_plan_codes_from_db[i];
                    if (rate_plan_code_db.rate_plan_code == RPCode) {

                      is_upcharged = true;

                      total_percent = (rate_plan_code_db.percentage) / 100;
                      percent_added = rate_plan_code_db.percentage;
                      percent_to_remove = rate_plan_code_db.percentage / 100;

                      show_by_rate_plan_code = "show_by_rate_plan_code_true";

                    }

                  }

                } else {

                  show_by_rate_plan_code = "";

                }





                var total_from_api = parseFloat(Total.AmountAfterTax);


                if (total_percent != 0 || total_percent == 'undefined') {

                  var percent_val = total_from_api * total_percent;

                } else {

                  var percent_val = 0;

                }



                var percent_val_to_remove = total_from_api * percent_to_remove;



                var percent_val_to_remove_after = total_from_api;



                var total_after_percent = percent_val_to_remove_after + percent_val;


                var no_of_nights = parseInt(jQuery("#number_of_nights").attr('data_value'));


                var per_day_price = total_after_percent;


                var actual_per_day_price = per_day_price;


                var actual_total_price = actual_per_day_price / no_of_nights;







                var totalRoomPrice = parseFloat(actual_per_day_price);

                var comparePrice = parseFloat(actual_total_price) + parseFloat(20);

                var perDayRoomPrice = actual_total_price;

                
                currentElement.addClass('hotelWithPrice');

                currentElement.find(".price_area").attr("data_price", perDayRoomPrice.toFixed(2));

                currentElement.find(".price_area").find(".compare_price").html(comparePrice.toFixed(2));


                currentElement.find(".price_area").find(".room_price").html(perDayRoomPrice.toFixed(2));

                currentElement.find(".price_area").find(".total_price").html(totalRoomPrice.toFixed(2));

                currentElement.find(".price_area").find(".number_of_nights").html(number_of_nights);

                currentElement.find(".price_area").removeClass('d-none');

                currentElement.find(".price_loader").addClass('d-none');

              } else {

                var currency_conversions = response.CurrencyConversions;


                var currency_conversions_string = JSON.stringify(currency_conversions);

                var currency_code = currency_conversions.SourceCurrencyCode;

                var requested_currency_code = currency_conversions.RequestedCurrencyCode;

                var room_price = Room.Total.AmountAfterTax;
                var per_day_price = Room.Total.AmountAfterTax;
                var gbk_rate = Room.Total.AmountAfterTax;
                var prc_from_api = Room.Total.AmountAfterTax;




                jQuery.ajax({
                  url: GET_CURRENCY_SYMBOL_URL,
                  type: "POST",
                  data: {
                    currency: currency_code,
                    requested_currency_code: requested_currency_code,
                    currency_conversions: currency_conversions_string,
                    room_price: room_price,
                    per_day_price: per_day_price,
                    gbk_rate: gbk_rate,
                    prc_from_api: prc_from_api
                  },
                  headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response, textStatus, jqXHR) {



                    cTarget.html(response.symbol);

                    if (response.is_converted) {

                      console.log('currentElement', currentElement);


                      let total_percent = 0;
                      let percent_added = 0;
                      let percent_to_remove = 0;
                      let is_upcharged = false;

                      let show_by_rate_plan_code = '';

                      if (rate_plan_codes_from_db.length > 0) {



                        for (var i = 0; i < rate_plan_codes_from_db.length; i++) {

                          show_by_rate_plan_code = "show_by_rate_plan_code_false";


                          var rate_plan_code_db = rate_plan_codes_from_db[i];
                          if (rate_plan_code_db.rate_plan_code == RPCode) {

                            is_upcharged = true;

                            total_percent = (rate_plan_code_db.percentage) / 100;
                            percent_added = rate_plan_code_db.percentage;
                            percent_to_remove = rate_plan_code_db.percentage / 100;

                            show_by_rate_plan_code = "show_by_rate_plan_code_true";

                          }

                        }

                      } else {

                        show_by_rate_plan_code = "";

                      }





                      var total_from_api = parseFloat(response.room_price);


                      if (total_percent != 0 || total_percent == 'undefined') {

                        var percent_val = total_from_api * total_percent;

                      } else {

                        var percent_val = 0;

                      }



                      var percent_val_to_remove = total_from_api * percent_to_remove;



                      var percent_val_to_remove_after = total_from_api;



                      var total_after_percent = percent_val_to_remove_after + percent_val;


                      var no_of_nights = parseInt(jQuery("#number_of_nights").attr('data_value'));


                      var per_day_price = total_after_percent;


                      var actual_per_day_price = per_day_price;


                      var actual_total_price = actual_per_day_price / no_of_nights;







                      var totalRoomPrice = parseFloat(actual_per_day_price);

                      var comparePrice = parseFloat(actual_total_price) + parseFloat(20);

                      var perDayRoomPrice = actual_total_price;



                      currentElement.addClass('hotelWithPrice');

                      currentElement.attr("data-is_currency_converted", "true");



                      var no_of_nights = parseInt(jQuery("#number_of_nights").attr('data_value'));





                      currentElement.find(".price_area").attr("data_price", perDayRoomPrice.toFixed(2));

                      currentElement.find(".price_area").find(".compare_price").html(comparePrice.toFixed(2));


                      currentElement.find(".price_area").find(".room_price").html(perDayRoomPrice.toFixed(2));

                      currentElement.find(".price_area").find(".total_price").html(totalRoomPrice.toFixed(2));

                      currentElement.find(".price_area").find(".number_of_nights").html(number_of_nights);




                      currentElement.find(".price_loader").addClass('d-none');


                      currentElement.find(".price_area").removeClass('d-none');



                    }



                  },
                  error: function(jqXHR, textStatus, errorThrown) {

                    console.log(errorThrown);

                  }
                });

              }





            }

          } else if (response.hasOwnProperty('error')) {

            var ErrorCode = response.error;

            if (ErrorCode) {



              currentElement.find(".price_loader").addClass('d-none');


              /*currentElement.closest('.single_hotel').addClass('d-none');*/

              currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');

            } else {



              getHotelPriceAgain(hotelCode, currentElement);

              currentElement.find(".price_loader").addClass('d-none');


            }

            currentElement.find(".price_loader").addClass('d-none');

            /*currentElement.closest('.single_hotel').addClass('d-none');*/

            currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


          } else {




            getHotelPriceAgain(hotelCode, currentElement);

            currentElement.find(".price_loader").addClass('d-none');




            /*currentElement.closest('.single_hotel').addClass('d-none');*/

            currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


          }

          currentElement.find(".price_loader").addClass('d-none');

          

          if(html_hotel_counter === html_response_counter){
            jQuery(document).trigger("hotel_prices_loaded");
          }else{
            $('#hotels_loader').removeClass('d-none');
          }

          html_response_counter++;

        }
      });

      


    
        });

      }

      

    }


    




  });



  jQuery(document).on("hotel_prices_loaded",function(){


    jQuery("#hotels_loader").addClass('d-none');


    setTimeout(function(){

      jQuery(".single_hotel").addClass("d-none");

      jQuery(".hotelWithPrice").removeClass("d-none");

      

      var total_hotel_prices_loaded = jQuery("body .hotelWithPrice").length;


      /*jQuery("body .hotelWithoutPrice").each(function() {

      	

      	var currentElement = jQuery(this);

      	currentElement.addClass('hotelWithoutPriceButShowHotel');
      	currentElement.removeClass('hotelWithoutPrice');
      	currentElement.find(".price_area").addClass('d-none');
      	currentElement.removeClass('d-none');
      	
      	
      });*/



      jQuery("#show_all_load_hotel").html(total_hotel_prices_loaded);

      jQuery("#event_hotels_counter_container").removeClass('d-none');

      if(jQuery("body .hotelWithoutPriceButShowHotel").length > 0){
      	var show_total = jQuery("body .hotelWithoutPriceButShowHotel").length;
      	var complete_total = show_total + total_hotel_prices_loaded;

      	jQuery("#show_all_load_hotel").html(complete_total);

      }

      jQuery("#event_hero_section").removeClass('d-none');

      jQuery("#total_hotels").removeClass('d-none');

  	jQuery("#event-details-section").removeClass('d-none');


  	jQuery("#search-bar").removeClass('d-none');


  	jQuery("#cta_section").removeClass('d-none');

  	


      
      jQuery("#hotels").removeClass('d-none');

      jQuery("#total_hotels").removeClass('d-none');


      if(total_hotel_prices_loaded == 0){

        jQuery("#hotels_not_found_error").removeClass("d-none");

      }
      

    }, 300);



  });


  jQuery("#getPricesAgain").on("click", function() {

    jQuery('.single_hotel').removeClass('d-none');

    var checkin = jQuery("#check-in").val();
    var checkout = jQuery("#check-out").val();

    var number_of_guest = jQuery("#guests").val();

    var number_of_rooms = jQuery("#rooms").val();

    jQuery(".price_loader").removeClass('d-none');


    jQuery('.single_hotel').each(function() {



      var currentElement = $(this);

      var cTarget = jQuery(this).find(".currencySymbol");

      var is_success = currentElement.attr("is_success");

      var hotelCode = currentElement.attr("data-hotel_code");

      var chainCode = hotelCode.substring(0, 2);

      var cityCode = hotelCode.substring(2, 5);

      currentElement.find(".price_area").addClass('d-none');

      currentElement.find(".price_area").addClass('d-none');




      jQuery.ajax({
        type: 'GET',
        url: "{{ url('get-soap-amadeus-hotel-rooms')}}",
        data: {
          monoproperty: true,
          hotelcode: hotelCode,
          chainCode: chainCode,
          cityCode: cityCode,
          checkin: checkin,
          checkout: checkout,
          guest_count: number_of_guest,
          rooms_count: number_of_rooms,
          endTr: "true"

        },

        success: function(response) {


          if (response.hasOwnProperty('rooms')) {




            var number_of_nights = response.number_of_nights;
            jQuery("#number_of_nights").attr('data_value', number_of_nights);


            var TotalRooms = response.rooms.RoomStay.length;

            var rate_plan_upcharge = response.rate_plan_upcharge;

            if (TotalRooms > 0) {




              var Room = getSortedFirstRoom(response.rooms.RoomStay, rate_plan_upcharge);

              if (Room.Total.CurrencyCode == "USD") {




                var totalRoomPrice = parseFloat(Room.RoomRates.RoomRate.Total.AmountAfterTax);

                var comparePrice = parseFloat(totalRoomPrice) + parseFloat(20);

                var perDayRoomPrice = totalRoomPrice / number_of_nights;



                currentElement.find(".price_area").attr("data_price", perDayRoomPrice.toFixed(2));

                currentElement.find(".price_area").find(".compare_price").html(comparePrice.toFixed(2));


                currentElement.find(".price_area").find(".room_price").html(perDayRoomPrice.toFixed(2));

                currentElement.find(".price_area").find(".total_price").html(totalRoomPrice.toFixed(2));

                currentElement.find(".price_area").find(".number_of_nights").html(number_of_nights);

                currentElement.find(".price_area").removeClass('d-none');

                currentElement.find(".price_loader").addClass('d-none');


              } else {

                var currency_conversions = response.CurrencyConversions;

                var currency_conversions_string = JSON.stringify(currency_conversions);
                var currency_code = currency_conversions.SourceCurrencyCode;

                var requested_currency_code = currency_conversions.RequestedCurrencyCode;

                var room_price = Room.Total.AmountAfterTax;
                var per_day_price = Room.Total.AmountAfterTax;
                var gbk_rate = Room.Total.AmountAfterTax;
                var prc_from_api = Room.Total.AmountAfterTax;

                jQuery.ajax({
                  url: GET_CURRENCY_SYMBOL_URL,
                  type: "POST",
                  data: {
                    
                    currency: currency_code,
                    requested_currency_code: requested_currency_code,
                    currency_conversions: currency_conversions_string,
                    room_price: room_price,
                    per_day_price: per_day_price,
                    gbk_rate: gbk_rate,
                    prc_from_api: prc_from_api
                  },
                  headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response, textStatus, jqXHR) {

                    cTarget.html(response.symbol);

                    if (response.is_converted) {

                      console.log('currentElement', currentElement);


                      currentElement.attr("room-price", response.room_price);

                      currentElement.attr("prc-from-api", response.prc_from_api);

                      currentElement.attr("gbk_rate", response.gbk_rate);

                      currentElement.attr("per_day_price", response.per_day_price);

                      currentElement.attr("data-is_currency_converted", "true");



                      var no_of_nights = parseInt(jQuery("#number_of_nights").attr('data_value'));

                      currentElement.find(".price_area").find(".number_of_nights").html(no_of_nights);

                      var calculated_price = response.room_price / no_of_nights;

                      var compare_price = parseFloat(calculated_price) + parseInt(20);

                      currentElement.find(".compare_price").html(compare_price);




                      currentElement.find(".currency_symbol").html(response.symbol);

                      currentElement.find(".price_value").html(calculated_price.toFixed(2));

                      currentElement.find(".room_price").html(calculated_price);

                      currentElement.find(".total_price").html(response.room_price);



                      currentElement.find(".price_loader").addClass('d-none');


                      currentElement.find(".price_area").removeClass('d-none');



                    }



                  },
                  error: function(jqXHR, textStatus, errorThrown) {

                    console.log(errorThrown);

                  }
                });
              }






            }

          } else if (response.hasOwnProperty('error')) {

            var ErrorCode = response.error;

            if (ErrorCode) {



              currentElement.find(".price_loader").addClass('d-none');


              /*currentElement.closest('.single_hotel').addClass('d-none');*/

              currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');

            } else {



              getHotelPriceAgain(hotelCode, currentElement);

              currentElement.find(".price_loader").addClass('d-none');



            }

            currentElement.find(".price_loader").addClass('d-none');

            /*currentElement.closest('.single_hotel').addClass('d-none');*/

            currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


          } else {




            getHotelPriceAgain(hotelCode, currentElement);

            currentElement.find(".price_loader").addClass('d-none');




            /*currentElement.closest('.single_hotel').addClass('d-none');*/

            currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


          }

          currentElement.find(".price_loader").addClass('d-none');



        }
      });



    });





  });

  function getSortedFirstRoom(obj, rate_plan_upcharge) {



    if (rate_plan_upcharge == '') {

      var t = obj.sort(function(x, y) {
        return x["Total"]["AmountAfterTax"] - y["Total"]["AmountAfterTax"]
      });

      return t[0];

    } else {



      var new_obj = [];


      for (var j = 0; j < rate_plan_upcharge.length; j++) {

        for (var i = 0; i < obj.length; i++) {

          var price_rpc = obj[i]["RoomRates"]["RoomRate"]["RatePlanCode"];

          if (rate_plan_upcharge[j].rate_plan_code == price_rpc) {

            new_obj.push(obj[i]);

          }


        }

      }

      if (new_obj) {

        var t = new_obj.sort(function(x, y) {
          return x["Total"]["AmountAfterTax"] - y["Total"]["AmountAfterTax"]
        });

        return t[0];
      }




    }





  }


  function sortAgain(t) {
    console.log('From RPC Calc');
    delete t[0];
    var obj = t;

    var t = obj.sort(function(x, y) {
      return x["Total"]["AmountAfterTax"] - y["Total"]["AmountAfterTax"]
    });

    console.log('t:', t);

    return t;

  }



  jQuery("body").on("change", "#event_change", function() {

  	console.log("Running From 2");  	

    
    jQuery("#total_hotels").addClass('d-none');

    jQuery("#hotels_not_found_error").addClass('d-none');

    

    var event_id = jQuery("#event_change").val();

    jQuery("#detailMap_"+event_id).remove();

    jQuery("#event_hotels_counter_container").addClass("d-none");

    jQuery("#hotels").addClass("d-none");

    jQuery("#hotels_loader").removeClass("d-none");    


    jQuery("#show_event_event_location_hide").addClass("d-none");
    jQuery("#show_event_event_location_hide2").removeClass("d-none");

    jQuery("#current_event_name_hide").addClass("d-none");
    jQuery("#current_event_name_hide2").removeClass("d-none");

    
    jQuery("#main_image_hide2").removeClass("d-none");
    jQuery("#main_image_hide").addClass("d-none");

    jQuery("#event_hotels_counter_container").addClass("d-none");


    var event_id = jQuery("#event_change").val();
    

    $.ajax({


      url: "{{ url('child-event-data-by-event-id') }}/" + event_id,

      data: {
        event_id:event_id,
        guest_count: jQuery("#guests").val(),
        checkin: jQuery("#check-in").val(),
        checkout:jQuery("#check-out").val()

      },

      type: 'post',
      headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      },



      success: function(result) {

        console.log(result);

        jQuery('#show_event_event_location_hide2').attr('data-event-id',result.event_id);



        jQuery('#selected_text').text(' Accomodations In The '+result.city+' Area ');

        jQuery("#show_event_event_location_hide2").attr('data-orign-event-complete-address',result.event_address);


        jQuery("#show_event_event_location_hide2").attr('data-orign-event-address-latitude',result.latitude);

        jQuery("#show_event_event_location_hide2").attr('data-orign-event-address-longitude',result.longitude);

        

        jQuery('#check-in').val(result.original_start_date);
        jQuery('#check-out').val(result.original_end_date);
        jQuery('#front-search-field').val(result.city);


        jQuery('#show_event_start_date').html(result.start_date);
        jQuery('#show_event_end_date').html(result.end_date);

        jQuery('#address_line_1').html(result.address_line_1);
        jQuery('#address_city').html(result.city);
        jQuery('#get_state').html(result.get_state);
        jQuery('#postal_code').html(result.postal_code);

        jQuery('#current_event_name_hide2').html(result.name);

        jQuery('#current_event_name_hide2').attr('data-event-name',result.name);

        jQuery('#main_image_hide2').attr('src', result.image_url);

        localStorage.setItem("city_code", result.city_code);
        localStorage.setItem("city_id", result.city_id);

        jQuery("#city_code").val(result.city_code);

        jQuery("#city_id").val(result.city_id);

        jQuery("#hotels").html(result.hotels);

        var html_hotel_counter = jQuery("body .single_hotel").length;

        var html_response_counter = 1;

        jQuery('.single_hotel').removeClass('d-none');

        var checkin = jQuery("#check-in").val();
        var checkout = jQuery("#check-out").val();

        var number_of_guest = jQuery("#guests").val();

        var number_of_rooms = jQuery("#rooms").val();




        jQuery(".price_loader").removeClass('d-none');



        var event_id = jQuery("#show_event_event_location_hide2").attr("data-event-id");

        var new_map_id = "detailMap_"+result.event_id;

        jQuery("body .map").addClass('d-none');

        jQuery("body .map").removeClass('active-map');

        jQuery('#maps').append('<div id="'+new_map_id+'" class="map" style="min-height: 80vh; width: 100% !important; outline: 1px solid black;" ></div>');  

        

        var lat = jQuery("#show_event_event_location_hide2").attr("data-orign-event-address-latitude");

        var long = jQuery("#show_event_event_location_hide2").attr("data-orign-event-address-longitude");

        var event_name = jQuery("#current_event_name_hide2").attr("data-event-name");

        var event_address = jQuery("#show_event_event_location_hide2").attr("data-orign-event-complete-address");


        

        jQuery("#mapModalLabel").text(event_address);


        var map = L.map(new_map_id).setView([lat, long], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([lat, long]).addTo(map)
            .bindPopup('<b>'+event_name+'</b> <br> '+event_address);

            jQuery("#"+new_map_id).addClass("active-map");
            jQuery("#"+new_map_id).removeClass('d-none');

            setTimeout(function() {
        
              map.invalidateSize();
            }, 600);

            jQuery('#mapModal').on('show.bs.modal', function(){

              setTimeout(function() {
          
                map.invalidateSize();

              }, 600);
      

      
            });
        


        /*get price again start */

        if(result.hotels != ""){

          jQuery(document).trigger("hotels_loaded");

        	jQuery('body .single_hotel').each(function() {


          console.log("Running Change  Each 2");

          var currentElement = $(this);

          var cTarget = jQuery(this).find(".currencySymbol");

          var is_success = currentElement.attr("is_success");

          var hotelCode = currentElement.attr("data-hotel_code");

          var chainCode = hotelCode.substring(0, 2);

          var cityCode = hotelCode.substring(2, 5);

          currentElement.find(".price_area").addClass('d-none');

          

          jQuery.ajax({
            type: 'GET',
            url: "{{ url('get-soap-amadeus-hotel-rooms')}}",
            data: {
              monoproperty: true,
              hotelcode: hotelCode,
              chainCode: chainCode,
              cityCode: cityCode,
              checkin: checkin,
              checkout: checkout,
              guest_count: number_of_guest,
              rooms_count: number_of_rooms,
              endTr: "true"

            },

            success: function(response) {


              if (response.hasOwnProperty('rooms')) {




                var number_of_nights = response.number_of_nights;
                jQuery("#number_of_nights").attr('data_value', number_of_nights);


                var TotalRooms = response.rooms.RoomStay.length;

                var rate_plan_upcharge = response.rate_plan_upcharge;

                if (TotalRooms > 0) {




                  var Room = getSortedFirstRoom(response.rooms.RoomStay, rate_plan_upcharge);

                  if (Room.Total.CurrencyCode == "USD") {




                    var totalRoomPrice = parseFloat(Room.RoomRates.RoomRate.Total.AmountAfterTax);

                    var comparePrice = parseFloat(totalRoomPrice) + parseFloat(20);

                    var perDayRoomPrice = totalRoomPrice / number_of_nights;


                    currentElement.addClass('hotelWithPrice');

                    currentElement.find(".price_area").attr("data_price", perDayRoomPrice.toFixed(2));

                    currentElement.find(".price_area").find(".compare_price").html(comparePrice.toFixed(2));


                    currentElement.find(".price_area").find(".room_price").html(perDayRoomPrice.toFixed(2));

                    currentElement.find(".price_area").find(".total_price").html(totalRoomPrice.toFixed(2));

                    currentElement.find(".price_area").find(".number_of_nights").html(number_of_nights);

                    currentElement.find(".price_area").removeClass('d-none');

                    currentElement.find(".price_loader").addClass('d-none');


                  } else {

                    var currency_conversions = response.CurrencyConversions;

                    var currency_conversions_string = JSON.stringify(currency_conversions);
                    var currency_code = currency_conversions.SourceCurrencyCode;

                    var requested_currency_code = currency_conversions.RequestedCurrencyCode;

                    var room_price = Room.Total.AmountAfterTax;
                    var per_day_price = Room.Total.AmountAfterTax;
                    var gbk_rate = Room.Total.AmountAfterTax;
                    var prc_from_api = Room.Total.AmountAfterTax;

                    jQuery.ajax({
                      url: GET_CURRENCY_SYMBOL_URL,
                      type: "POST",
                      data: {
                        currency: currency_code,
                        requested_currency_code: requested_currency_code,
                        currency_conversions: currency_conversions_string,
                        room_price: room_price,
                        per_day_price: per_day_price,
                        gbk_rate: gbk_rate,
                        prc_from_api: prc_from_api
                      },
                      headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(response, textStatus, jqXHR) {

                        cTarget.html(response.symbol);

                        if (response.is_converted) {

                          console.log('currentElement', currentElement);

                          currentElement.addClass('hotelWithPrice');

                          currentElement.attr("room-price", response.room_price);

                          currentElement.attr("prc-from-api", response.prc_from_api);

                          currentElement.attr("gbk_rate", response.gbk_rate);

                          currentElement.attr("per_day_price", response.per_day_price);

                          currentElement.attr("data-is_currency_converted", "true");



                          var no_of_nights = parseInt(jQuery("#number_of_nights").attr('data_value'));

                          currentElement.find(".price_area").find(".number_of_nights").html(no_of_nights);

                          var calculated_price = response.room_price / no_of_nights;

                          var compare_price = parseFloat(calculated_price) + parseInt(20);

                          currentElement.find(".compare_price").html(compare_price);




                          currentElement.find(".currency_symbol").html(response.symbol);

                          currentElement.find(".price_value").html(calculated_price.toFixed(2));

                          currentElement.find(".room_price").html(calculated_price);

                          currentElement.find(".total_price").html(response.room_price);



                          currentElement.find(".price_loader").addClass('d-none');


                          currentElement.find(".price_area").removeClass('d-none');



                        }



                      },
                      error: function(jqXHR, textStatus, errorThrown) {

                        console.log(errorThrown);

                      }
                    });
                  }






                }

              } else if (response.hasOwnProperty('error')) {

                var ErrorCode = response.error;

                if (ErrorCode) {



                  currentElement.find(".price_loader").addClass('d-none');


                  /*currentElement.closest('.single_hotel').addClass('d-none');*/

                  currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');

                } else {



                  getHotelPriceAgain(hotelCode, currentElement);

                  currentElement.find(".price_loader").addClass('d-none');



                }

                currentElement.find(".price_loader").addClass('d-none');

                /*currentElement.closest('.single_hotel').addClass('d-none');*/

                currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


              } else {




                getHotelPriceAgain(hotelCode, currentElement);

                currentElement.find(".price_loader").addClass('d-none');




                /*currentElement.closest('.single_hotel').addClass('d-none');*/

                currentElement.closest('.single_hotel').addClass('hotelWithoutPrice');


              }

              currentElement.find(".price_loader").addClass('d-none');

              

              if(html_hotel_counter === html_response_counter){
                jQuery(document).trigger("hotel_prices_loaded");
              }else{
                $('#hotels_loader').removeClass('d-none');
              }

              html_response_counter++;



            }
          });



        });

        }else{

          jQuery(document).trigger("hotels_not_loaded");
        	

        }

        








        /*get price again end*/




      },

      error: function(request, error) {

      }

    });




  });

jQuery(document).ready(function(){

    /*Map  Script*/

    var event_id = jQuery("#show_event_event_location_hide").attr("data-event-id");

    var lat = jQuery("#show_event_event_location_hide").attr("data-orign-event-address-latitude");

    var long = jQuery("#show_event_event_location_hide").attr("data-orign-event-address-longitude");

    var event_name = jQuery("#current_event_name_hide").text();

    var event_address = jQuery("#show_event_event_location_hide").text();

    

    jQuery("#mapModalLabel").text(event_address);



    var map = L.map('detailMap_'+event_id).setView([lat, long], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, long]).addTo(map)
        .bindPopup('<b>'+event_name+'</b> <br> '+event_address);

    jQuery('#mapModal').on('show.bs.modal', function(){


      

      setTimeout(function() {
        
        map.invalidateSize();
      }, 600);
     });



    jQuery("#showMapModal").on("click",function(){

      jQuery('#mapModal').modal('show'); 
      

    });



});

jQuery(document).on("hotels_loaded",function(){
  console.log("Running hotels_loaded");
  jQuery("#hotels").removeClass('d-none');
  jQuery("#hotels_loader").addClass('d-none');
  jQuery("#hotels_not_found_error").addClass('d-none');
  
});

jQuery(document).on("hotels_not_loaded",function(){
  console.log("Running hotels_not_loaded");
  jQuery("#hotels_loader").addClass('d-none');
  jQuery("#hotels_not_found_error").removeClass('d-none');  
});

jQuery(document).ready(function(){
  if(jQuery("#event_change").val() == ''){
    jQuery("#event_change").addClass('d-none');
  }
});

jQuery(document).ready(function(){

    

    

    

    if(jQuery("#event_change").val() != ''){
      jQuery("#event_change").one().trigger("change");  
    }else{
      jQuery("#event_change").addClass('d-none');
    } 





  });


jQuery('#mapModal').on('show.bs.modal', function(){

                    
        


        if(jQuery("#event_change").val() == ""){

          

          var event_id = jQuery("#show_event_event_location_hide").attr("data-event-id");


          

          var new_map_id = "detailMap_"+event_id;       
          
         

      
          jQuery("#"+new_map_id).removeClass('d-none');
      



                

                   

                    
      
          


      }
            

            
                  }); 


</script>



@endpush




@stop


