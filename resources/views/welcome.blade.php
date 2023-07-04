@inject('helper', 'App\Http\Controllers\helper')
<?php use App\Http\Controllers\helper;
?>
@extends('layout')

@section('header')
    <script src="//code.tidio.co/mhqsxix4cg7nghtwrkghhbidq7lnmjg6.js" async></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        .icon-size {
            font-size: 20px;

        }

        .slider-table td,
        th {
            padding: 0px 16px;
            text-align: center;
        }

        .slider-table td+td {
            border-left: 1px solid;

        }

        .slider-icons {
            color: #ffffffda;
            font-size: 22px;
        }

        .slider-data {
            color: #ffffffda;

        }

        .slider-data-type {
            color: #ffffff56;
            font-size: 13px;
            font-weight: 200;
        }
    </style>
@endsection

@section('body')
    <!-- Slider Start
    =========================================================================-->
    <div id="slider" style="height:1080px;margin:0 auto;margin-bottom: 0px;">

        @foreach ($adminPost as $post)
            <!-- Slide 1-->
            <div class="ls-slide"
                data-ls="bgsize:cover; bgposition:50% 50%; duration:4000; transition2d:5; kenburnsscale:1.2; parallaxtype:3d; parallaxdistance:4; parallaxrotate:20;">
                <img width="1920" height="1080" src="{{ asset('assets/images/slider/6.jpg') }}" class="ls-bg"
                    alt="" />
                <img width="340" height="200" src="{{ asset('assets/images/slider/6.jpg') }}" class="ls-tn"
                    alt="" />
                <div style="width:875px; height:410px; background:#ffffff; border-radius:0px; top:75px; left:20px;"
                    class="ls-l"
                    data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:50% 50% -300px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:50% 50% -300px; parallax:true; parallaxlevel:20;">
                </div>

                <div style="text-align:center; width:100px; height:35px; line-height: 35px; font-family:'Roboto'; font-size:15px; color:#ffffff; border-radius:0px; top:58px; left:66px;"
                    class="ls-l bg-primary"
                    data-ls="delayin:2000; easingin:easeOutElastic; rotateyin:-300; durationout:400; rotateyout:-400; parallaxlevel:0;">
                    {{ $post->propertyCate->purpose }}
                </div>
                <p style="font-weight:700;letter-spacing:-0.03em;font-family:Montserrat; font-size:30px; line-height:36px; color:#242424; top:121px; left:66px;"
                    class="ls-l"
                    data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:78.2% 416.7% -700px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:78.2% 416.7% -700px; parallax:true; parallaxlevel:35;">
                    {{ $post->property_title }}
                </p>
                <p style="font-weight:700; letter-spacing:-0.03em;font-family:Montserrat; font-size:24px; line-height:36px; color:#fd8e34; top:177px; left:66px;"
                    class="ls-l"
                    data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:270.5% 275% -600px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:270.5% 275% -600px; parallax:true; parallaxlevel:30;">
                    PKR{{ $helper::labelWithAmount($post->price) }}</p>
                <p style="font-weight:400;width:310px; font-family:Roboto; font-size:14px; line-height:24px; color:#666666; top:235px; left:69px; white-space:normal;"
                    class="ls-l"
                    data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:124.7% 32.5% -500px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:124.7% 32.5% -500px; parallax:true; parallaxlevel:25;">
                    {{ $post->description }}.
                </p>
                <p style="font-weight:400;cursor:pointer; letter-spacing: 1px; padding-right:30px; padding-left:30px; font-family:Montserrat; font-size:16px; line-height:50px; color:#ffffff; background:#fd9834; border-radius:0px; top:385px; left:66px;"
                    class="ls-l"
                    data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:199.2% -244.4% -600px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:199.2% -244.4% -600px; hover:true; hoverdurationin:300; hoveropacity:1; hoverbgcolor:#ffa319; parallax:true; parallaxlevel:30;">
                    <a style="text-decoration: none;color:white" href="{{ route('singlePage', ['id' => $post->id]) }}"> View
                        Details
                    </a>
                </p>

                @if ($post->postImages->count() > 0)
                    @if (count($post->postImages) >= 1)
                        <a href="{{ route('singlePage', ['id' => $post->id]) }}">
                            <img width="618" height="304"
                                src="{{ asset('propertyImages/' . $post->postImages[0]->img_path) }}" class="ls-l"
                                alt="" style="top:205px; left:374px;"
                                data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:13.2% 24.3% -1000px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:13.2% 24.3% -1000px; parallax:true; parallaxlevel:50;">
                        </a>
                    @endif
                    <a style="" class="ls-l" href="{{ route('singlePage', ['id' => $post->id]) }}" target="_self"
                        data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:-185.1% 134.1% -1400px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:-185.1% 134.1% -1400px; hover:true; hoveropacity:1; hoverscalex:0.95; hoverscaley:0.95; parallax:true; parallaxlevel:70;">
                        @if (count($post->postImages) >= 2)
                            <img width="185" height="185"
                                src="{{ asset('propertyImages/' . $post->postImages[1]->img_path) }}"
                                class=" ls-imagelightbox" alt="" style="border-radius:50%; top:31px; left:798px;">
                        @endif
                    </a>

                    <a style="" class="ls-l" href="{{ route('singlePage', ['id' => $post->id]) }}" target="_self"
                        data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:-149.2% 170.4% -1200px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:-149.2% 170.4% -1200px; hover:true; hoveropacity:1; hoverscalex:0.95; hoverscaley:0.95; parallax:true; parallaxlevel:60;">
                        @if (count($post->postImages) >= 3)
                            <img width="125" height="125"
                                src="{{ asset('propertyImages/' . $post->postImages[2]->img_path) }}"
                                class=" ls-imagelightbox" alt="" style="border-radius:50%; top:66px; left:642px;">
                        @endif
                    </a>
                @else
                    <img width="618" height="304" src="{{ asset('houseLog.jpg') }}" class="ls-l" alt=""
                        style="top:205px; left:374px;"
                        data-ls="offsetxin:-150; durationin:2000; easingin:easeOutExpo; rotateyin:-30; transformoriginin:13.2% 24.3% -1000px; offsetxout:100; durationout:800; easingout:easeInExpo; rotateyout:30; transformoriginout:13.2% 24.3% -1000px; parallax:true; parallaxlevel:50;">
                @endif
                <div width="800" height="173" class="ls-l ls-hide-phone ls-hide-tablet" alt=""
                    style="width:283px; top:503px; left:25px;"
                    data-ls="offsetyin:-100; durationin:1500; delayin:1000; easingin:easeOutExpo; durationout:400; easingout:easeInOutQuad; parallax:true; parallaxlevel:9;">
                    <table class="slider-table">
                        <tr class="slider-icons">
                            <th><i class="fa fa-plus-square "></i></th>
                            <th><i class="fa fa-bed"></i></th>
                            <th><i class="fa fa-bath"></i></th>
                            <th><i class="fa fa-home"></i></th>
                        </tr>
                        <tr class="slider-data">
                            <td>{{ $post->land_area }}</td>
                            <td>0{{ $post->bedrooms }}</td>
                            <td>0{{ $post->bathrooms }}</td>
                            <td>01</td>
                        </tr>
                        <tr class="slider-data-type">
                            <td>Marla</td>
                            <td>Bedrooms</td>
                            <td>Bathrooms</td>
                            <td>Garage</td>
                        </tr>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <!--form section
         ------------------>
    <div class="Ubackground" style="background-image: url('/public/assets/images/background/Ubackground.png');">

        <form id="main-search-form" method="GET" action="{{ route('property.search') }}" autocomplete="off"
            class="adbanced-form-two amenities-list border-top-1-gray">
            <input name="search" value="search" type="hidden">

            @if ($errors->hasBag('addPostError'))
                <p class="text-danger">


                    {{ $errors->addPostError->first('purpose') }}
                </p>
            @endif

            <div class="row" id="umer" style="margin-top: 138px">

                <div class="form-group col-lg-3 col-md-12 col-12 pt-15">
                    <div class="select-wrapper position-relative">
                        <select id="city" name="city" class="select form-control select2">

                            @foreach ($cities as $citii)
                                <option value="{{ $citii->city }}">{{ $citii->city }} </option>
                            @endforeach

                        </select>

                    </div>
                </div>

                <div class="form-group col-lg-3 col-md-12 col-12 pt-15">
                    <div class="select-wrapper position-relative">
                        <select id="location" name="city_area" class="form-control text-light bg-secondary select2  "
                            style="background-color: whitesmoke !important;color: ;m: black;color: black !important;">
                        </select>

                    </div>
                </div>

<div class="form-group col-lg-3 col-md-12 col-sm-12 px-0 pt-md-15">
  <div class="btn-group btn-group-toggle position-relative propBtns" style="width: 91%;margin-left: 6%" data-toggle="buttons">
    <label id="sale" style="margin-top: 15px;" class="btn btn-secondary" onclick="changecolor(id)">
      <input type="radio" name="purpose" class="property_type margin hg" value="sale" required />Sale
    </label>
    <label id="rent" style="margin-top: 15px" class="btn btn-secondary" onclick="changecolor(id)">
      <input type="radio" name="purpose" class="property_type" value="rent" />Rent
    </label>
  </div>
</div>


                <div class="form-group col-lg-3 px-lg-0  col-md-12  col-sm-12  col-sm-11 pt-15">

                    <div class="row pt-md-15">

                        <div class="form-group  col-md-6 px-lg-1 col-sm-12  col-sm-11">
                            <div class="select-wrapper position-relative">

                                @php
                                    
                                    if (isset($old_property_sub_type)) {
                                        $OPT = $old_property_sub_type;
                                    }
                                @endphp

                                <select name="sub_type" value="sub_type" id="mySelect" class="select form-control "
                                    onchange="mainInfox();">

                                    <option value="not_commercial">Commercial</option>

                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="commercial_plot" name="sub_type">Commercial plot</option>

                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="commercial_plot_file" name="sub_type">Commercial plot file</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="office" name="sub_type">Office</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="shop" name="sub_type">Shop</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="warehouse" name="sub_type">Warehouse</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="factory" name="sub_type">factory</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="agriculture_land" name="sub_type">Agriculture land</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="industrial_land" name="sub_type">Industrial land</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="farmhouse_plot" name="sub_type">Farmhouse plot</option>
                                    <option @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="gym" name="sub_type">Gym</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="plaza" name="sub_type">Plaza</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="land" name="sub_type">Land</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="hall" name="sub_type">Hall</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="farmhouse_plot" name="sub_type">Farmhouse plot</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_type" ?"selected":''} @endisset
                                        value="building" name="sub_type">Building</option>

                                </select>



                            </div>
                        </div>
                        <div class="form-group  col-md-6 px-lg-1  col-sm-12  col-sm-11">
                            <div class="select-wrapper position-relative">

                                @php
                                    
                                    if (isset($old_property_sub_type)) {
                                        $OPT = $old_property_sub_type;
                                    }
                                @endphp

                                <select name="sub_typee" value="sub_typee" id="Select" class="select form-control "
                                    onchange="mainInfo();">

                                    <option value="not_residential">Residential</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="home" name="sub_typee">home</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="guest_house" name="sub_typee">Guest house</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="appartment" name="sub_typee">Appartment</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="farm_house" name="sub_typee">Farm house</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="penthouse" name="sub_typee">Penthouse</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="hotel_suite" name="sub_typee">Hotel suite</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="basement" name="sub_typee">Basement</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="hostel" name="sub_typee">Hostel</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="flat" name="sub_typee">Flat</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="upper_portion" name="sub_typee">Upper portion</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="lower_portion">Lower portion</option>

                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="residential_plot" name="sub_typee">Residential plot</option>
                                    <option
                                        @isset($OPT) {$OPT=="sub_typee" ?"selected":''} @endisset
                                        value="residential_plot_file" name="sub_typee">Residential plot file</option>

                                </select>

                            </div>

                        </div>
                    </div>

                </div>

                <div class="form-group col-lg-3 col-md-12 col-sm-12 pt-15">
                    <div class="select-wrapper position-relative">
                        <select name="beds" class="select form-control has-val">
                            <option @isset($old_beds) {$old_beds=="null" ?"selected":''}@endisset
                                value="null">
                                Beds</option>
                            <option @isset($old_beds) {$old_beds=="1" ?"selected":''}@endisset
                                value="1">One
                            </option>
                            <option @isset($old_beds) {$old_beds=="2" ?"selected":''}@endisset
                                value="2">Two
                            </option>
                            <option @isset($old_beds) {$old_beds=="3" ?"selected":''}@endisset
                                value="3">Three
                            </option>
                            <option @isset($old_beds) {$old_beds=="4" ?"selected":''}@endisset
                                value="4">Four
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-0 pb-15 col-lg-3 col-md-12 col-12">
                    <div class="select-wrapper position-relative">
                        <div class="price-filter">

                            <input id="filter_sqft" type="text" name="area" value="{{ $old_area ?? '0;200' }}" />
                            <input type="" class="select form-control has-val" placehoder="0 to Any">


                        </div>
                    </div>
                </div>


                <div class="form-group mb-0 pb-15 col-lg-3 col-md-12 col-12">
                    <div class="select-wrapper position-relative">
                        <div class="price-filter">

                            <input class="filter_price" type="text" name="price" 
                                value="{{ $old_price ?? '0;90000000' }}" />
                            <input type="" class=" form-control " placehoder="">


                        </div>
                    </div>
                </div>


                <div class="form-group mb-0 pb-15 col-lg-3 col-md-12 col-12">

                    <button class="p-5  search" style="margin-top: 13px;background-color: orange; width:100%;"
                        type="submit">Search!</button>
                </div>

            </div>
        </form>
    </div>
    <!--form section end
         ------------->


    <!-- Slider End
    =========================================================================-->
    <!-- Feautred Properties Start
    =========================================================================-->
    <section class="featured-properties bg-light mt-5" style="margin-top: -150px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title w-75 mx-auto d-table text-center mb-30" style="margin-top: 91px">
                        <span class="small-title color-primary position-relative line-2-primary">Find Out the Best
                            One</span>

                        <h2 class="title mb-20 color-secondary">Featured Properties</h2>
                        <span class="sub-title" style="font-size: 135%" >Check out our Latest Properties section. Here you can find out
                            the latest six properties.
                        </span>
                    </div>
                    @include('customincludes.caraousel')
                </div>


            </div>
        </div>

    </section>
    <!-- Feautred Properties End
    =========================================================================-->

    <!-- Latest Properties Start
    =========================================================================-->
    <section style="margin-top:-150px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title w-75 mx-auto d-table text-center mb-30" style="margin-top: 91px">
                        <span class="small-title color-primary position-relative line-2-primary">Find Out the Best
                            One</span>

                        <h2 class="title mb-20 color-secondary">Latest Properties</h2>
                        <span class="sub-title" style="font-size: 135%" >Check out our Latest Properties section. Here you can find out
                            the latest six properties.
                        </span>
                    </div>
                    @include('customincludes.caraousel2')
                </div>


            </div>
        </div>

    </section>

    <!-- Latest Properties End
    =========================================================================-->

    <!-- Carasoul section start
    =============================================================-->


    <!--<div class="owl-carousel partners mt-30">-->
    <!--	<img src="{{ asset('houseLog.jpg') }}" alt="image" style="height:300px; ">-->
    <!--	<img src="{{ asset('houseLog.jpg') }}" alt="image" style="height:300px; ">-->
    <!--	<img src="{{ asset('houseLog.jpg') }}" alt="image" style="height:300px; ">-->
    <!--	<img src="{{ asset('houseLog.jpg') }}" alt="image" style="height:300px; ">-->
    <!--	<img src="{{ asset('houseLog.jpg') }}" alt="image" style="height:300px; ">-->
    <!--	<img src="{{ asset('houseLog.jpg') }}" alt="image" style="height:300px; ">-->
    <!--  </div>-->

    <!-- Carasoul section end
    ===============================================-->

    <!-- Feautred Properties End
    =========================================================================-->



    <!-- Why Choose Us Start
    =========================================================================-->
    <section class="position-relative" style="background: url(images/background/1.png) no-repeat bottom center / cover; margin-top: -258px">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-7">
                    <div class="bg-white p-50">
                        <div class="row">
                            <div class="col-md-10 col-lg-10">
                                <div class="side-title mb-30">
                                    <span class="small-title color-primary position-relative line-primary">Want A Better
                                        Life?</span>
                                    <h2 class="title mb-20 color-secondary">Buy A Property and Lead A Happy Life.</h2>
                                    <p>Owning a home is one of the most common financial goals in the Pakistan,
                                        and there are many reasons why. It’s a source of stability,
                                        it gives you control, it allows you to build equity,
                                        it reflects your style, and on some level,
                                        it’s associated with a feeling of success.</p>
                                </div>
                                <div class="why-us mt-30 flat-medium icon-primary">
                                    <ul>
                                        <li>
                                            <span class="float-left mr-15"><i style="font-size:40px"
                                                    class="fa fa-bed"></i></span>
                                            <div class="d-table">
                                                <h4 class="color-secondary mb-15">Location of the House</h4>
                                                <p>Location is key to valuable real estate.
                                                    Homes in cities that have little room for expansion tend to be
                                                    more valuable than those in cities that have plenty of room..</p>
                                            </div>
                                        </li>
                                        <li class="mt-30">
                                            <span class="float-left mr-15"><i style="font-size: 40px"
                                                    class="fa fa-car"></i></span>
                                            <div class="d-table">
                                                <h4 class="color-secondary mb-15">Parking Lot Size</h4>
                                                <p>The average size of a parking space is 320 square feet. However, there
                                                    are also other sizes available,
                                                    one of the most common of which is 270 square feet.
                                                    These sizes include the landscaping or end of aisle areas,
                                                    the circulation areas and the parking space. .</p>
                                            </div>
                                        </li>
                                        <li class="mt-30">
                                            <span class="float-left mr-15"><i style="font-size:40px"
                                                    class="fa fa-home"></i></span>
                                            <div class="d-table">
                                                <h4 class="color-secondary mb-15">Age of the House</h4>
                                                <p>A house is a concrete structure made of other earthly elements that are
                                                    bound to deteriorate over time.
                                                    Moreover, extreme weather,
                                                    environmental conditions and rigorous usage, damage the structure in its
                                                    own way..</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100">
                    <div class="fact-counter achievement text-center py-50 px-30 position-absolute bg-secondary">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="counter count wow">
                                    <div class="counter-point d-inline-block">
                                        <h2 class="count-num color-primary" data-speed="3000"
                                            data-stop="{{ $allPostNumber }}"></h2>
                                    </div>
                                    <h6 class="achievement-title color-white">Properties Listed</h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="counter count wow mt-sm-30">
                                    <div class="counter-point d-inline-block">
                                        <h2 class="count-num color-primary" data-speed="3000" data-stop="500"></h2>
                                    </div>
                                    <h6 class="achievement-title color-white">Locations Covers</h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="counter count wow mt-30">
                                    <div class="counter-point d-inline-block">
                                        <h2 class="count-num color-primary" data-speed="3000"
                                            data-stop="{{ $allAgentNumber }}">0</h2>
                                    </div>
                                    <h6 class="achievement-title color-white">Expert Agents</h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="counter count wow mt-30">
                                    <div class="counter-point d-inline-block">
                                        <h2 class="count-num color-primary" data-speed="3000"
                                            data-stop="{{ $allSoldProperty }}">0</h2>
                                    </div>
                                    <h6 class="achievement-title color-white">Properties Sold</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Choose Us Start
    =========================================================================-->

    <!-- Best Offer Start
    =========================================================================-->
    <section style="margin-top: -112px">
        <div class="container">
            <h2 class="title mb-20 color-secondary">Recent Blogs</h2>
            <p>Find the information which is compulsory for your daily life.</p>
    
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-md-12 col-lg-4">
                        <div class="post-thumbnail hover-secondery-primary mt-30">
                            <a href="{{ route('blogMainSingleView', ['id' => $blog->id]) }}">
                                <div class="post-img overflow-hidden"><img style="height: 200px"
                            src="{{ $blog->blogOneImage !=null ? asset('public/'.$blog->blogOneImage->img_path):''}}" alt="">
                    </div>
                            </a>
                            <div class="post-meta icon-primary color-secondary-a px-20 py-10 bg-gray">
                                <ul class="post-info list-style-1 d-flex color-secondary">
                                    <li><i class="fa fa-user"></i> Admin</li>
                                    {{-- <li><a href="#"><i class="fa fa-comments-o"></i>
                                            127</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-share-alt"></i> 86</a></li>
                                    --}}
                                </ul>
                            </div>
                            <div class="post-content mt-20 color-secondary color-secondary-a">
                                <div class="post-date w-25 float-left bg-gray mr-20 text-center">
                                    @php
                                        
                                        $dateArray = helper::DBDateToSimpleFormat($blog->created_at->toDateString());
                                        
                                    @endphp
                                    <div class="py-10"><span
                                            class="d-block">{{ $dateArray[0] }}</span>{{ $dateArray[1] }}</div>
                                    <div class="post-love py-5 bg-primary"><a href="#"><i class="fa fa-heart"
                                                aria-hidden="true"></i></a></div>
                                </div>
                                <div class="text-area d-table">
                                    <a class="post-title mb-15"
                                        href="{{ route('blogMainSingleView', ['id' => $blog->id]) }}">
                                        <h5>{{ $blog->title }}</h5>
                                    </a>
                                    {{-- <p>{{!! helper::conciseContent($blog->content) !!}}</p> --}}
                                    {{-- {!! html_entity_decode($blog->content) !!}  --}}


                                    <a class="btn-more mt-15"
                                        href="{{ route('blogMainSingleView', ['id' => $blog->id]) }}">Read
                                        More</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="mx-auto d-table">
                        <ul class="pagination mt-50">
                            <?php $items = $blogs->total();
                            
                            $loopValue = ceil($items / 12);
                            
                            $totalPage = $blogs->lastPage();
                            
                            $currentPage = $blogs->currentPage();
                            
                            ?>
                            <li class="page-item"><a class="{{ 1 >= $currentPage ? 'isDisabled page-link' : ' page-link ' }}"
                                    href="{{ url('rent/commercial/?page=' . ($currentPage - 1)) }}">Prev</a></li>
                            @for ($i = 1; $i <= $loopValue; $i++)
                                <li class="page-item">
                                    <a class="page-link active" href="{{ url('rent/commercial/?page=' . $i) }}">
                                        <span>{{ $i }}</span> </a>
                                </li>
                            @endfor

                            <li class="page-item"><a
                                    class=" {{ $totalPage <= $currentPage ? 'isDisabled page-link' : ' page-link ' }}"
                                    href="{{ url('rent/commercial/?page=' . ($currentPage + 1)) }}">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>            </div>
        </div>
    </section>
  
            <?php
            $i = 0;
            $p = $specialPost;
            ?>
 
    <!-- Best Offer End
    =========================================================================-->


    <!-- Our Agents Two Start
    ==================================================================-->
    <section class="agent-style-2;"  style="margin-top: -40px">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-5">
                    <div class="side-title mb-30">
                        <span class="small-title color-primary position-relative line-primary">Team</span>
                        <h2 class="title mb-20 color-secondary">Our Most Popular Agencies</h2>
                        <p>Are you looking for a new website for your growing real estate business?
                            Do you need help building your social media presence to start selling more homes and making more
                            connections?
                            We've analyzed agencies across Pakistan that specialize in real estate marketing to help you
                            find a marketing partner you can trust.
                            Considering that over 92% of homebuyers now use the internet to shop for houses,
                            making your real estate business stand out online is a must for success.
                            Check out our list of real estate marketing agencies here!.</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-7">
                    <div class="owl-carousel slide-6">

                        @foreach ($agencies as $agency)
                            <div class="agent-profile">
                                <div class="overflow-hidden"><img src="/image/{{ $agency->image }}" alt="image">
                                </div>
                                <div class="agent-profile-content hover-secondery-primary py-20 px-15 bg-white">
                                    <a class="mb-5 d-block" href="#">
                                        <h5>{{ $agency->name }}</h5>
                                    </a>
                                    <span class="color-gray"></span>
                                    <a class="btn-round bg-secondary" href="#"><i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Agents Two End
    ==================================================================-->
    <!-- Testimonial Start
    =========================================================================-->

    <!-- Blog End
    =========================================================================-->
    <!--  Partners and Subscribe Form Start
    =========================================================================-->
    <div class="patner-subscribe">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="bg-white shadow py-80">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 px-60 border-right">
                                <div class="side-title pb-30">
                                    <span class="small-title color-primary position-relative line-primary">Partners</span>
                                    <h2 class="title mb-20 color-secondary">Our Brands!</h2>
                                    <p>Syed Zameen By SYED REAL ESTATE .
                                        Syed zameen is a project of SYED REAL ESATAE ,
                                        Syed Real Estates and builders is the largest full-service real estate and property
                                        management company , They known for their quanlity work .

                                        .</p>
                                </div>
                                <div class="owl-carousel partners mt-30">
                                    <img src="{{ asset('login-logo.png') }}" alt="Image not found!">
                                    <img src="{{ asset('syedEstate Real logo.png') }}" alt="">

                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 px-60">
                                <div class="side-title pb-30 text-right mt-md-50">
                                    <span
                                        class="small-title color-primary position-relative line-right-primary">Newsletter</span>
                                    <h2 class="title mb-20 color-secondary">Get Update Now!</h2>
                                    <p>Wait a bit ! before leaving add your email we will notify you about new property and
                                        much more .</p>
                                </div>
                                <form class="news-letter bg-gray mt-30">
                                    <div id="subscribe-message" style="margin-bottom:2px;font-size:20px"></div>
                                    <div class="form-group position-relative" id="subscribe-hide">
                                        <input class="form-control" type="text" name="email"
                                            placeholder="Subscribe" id="subscribe-input">
                                        <button class="bg-gray color-secondary" id="btn-subscribe"><i
                                                class="fa fa-paper-plane"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function changecolor(id) {

            if (id == "sale") {
                document.getElementById("sale").style.borderColor = "balck";
                document.getElementById("rent").style.borderColor = "orange";

            }
            if (id == "rent") {

                document.getElementById("rent").style.borderColor = "green";
                document.getElementById("sale").style.borderColor = "orange";
            }

        }
    </script>


    <script>
        window.onload = function() {

            var cvt = $('.convrt b').contents();


            var sites = {!! json_encode($showlatestPost->toArray()) !!};

            //   cvt[2].data = sites[2].price;

            for (let index = 0; index < sites.length; index++) {

                // cvt[sites].data = sites[sites].price;

                var val = Math.abs(sites[index].price)
                if (val >= 10000000) {
                    val = (val / 10000000).toFixed(2) + ' Crore';
                } else if (val >= 100000) {
                    val = (val / 100000).toFixed(2) + ' Lakh';
                } else if (val >= 1000) {
                    val = (val / 1000).toFixed(2) + 'Thousand';
                }
                cvt[index].data = val;
                // return val;

            }

            var cnvt = $('.convrt2 b').contents();

            var pcr = {!! json_encode($showlatestPost2->toArray()) !!};

            for (let index = 0; index < pcr.length; index++) {

                // cvt[sites].data = sites[sites].price;

                var val = Math.abs(pcr[index].price)
                if (val >= 10000000) {
                    val = (val / 10000000).toFixed(2) + ' Crore';
                } else if (val >= 100000) {
                    val = (val / 100000).toFixed(2) + ' Lakh';
                } else if (val >= 1000) {
                    val = (val / 1000).toFixed(2) + 'Thousand';
                }
                cnvt[index].data = val;
                // return val;

            }

            var cnvt3 = $('.convrt3 b').contents();

            var price3 = {!! json_encode($showReallatestPost->toArray()) !!};

            for (let index = 0; index < price3.length; index++) {

                // cvt[sites].data = sites[sites].price;

                var val = Math.abs(price3[index].price)
                if (val >= 10000000) {
                    val = (val / 10000000).toFixed(2) + ' Crore';
                } else if (val >= 100000) {
                    val = (val / 100000).toFixed(2) + ' Lakh';
                } else if (val >= 1000) {
                    val = (val / 1000).toFixed(2) + 'Thousand';
                }
                cnvt3[index].data = val;
                // return val;

            }

            var cnvt4 = $('.convrt4 b').contents();

            var price4 = {!! json_encode($showReallatestPost2->toArray()) !!};

            for (let index = 0; index < price4.length; index++) {

                // cvt[sites].data = sites[sites].price;

                var val = Math.abs(price4[index].price)
                if (val >= 10000000) {
                    val = (val / 10000000).toFixed(2) + ' Crore';
                } else if (val >= 100000) {
                    val = (val / 100000).toFixed(2) + ' Lakh';
                } else if (val >= 1000) {
                    val = (val / 1000).toFixed(2) + 'Thousand';
                }
                cnvt4[index].data = val;
                // return val;
            }



        }
    </script>


    <script>
        function mainInfo() {
            document.getElementById("mySelect").value = "not_commercial"
        }

        function mainInfox() {
            document.getElementById("Select").value = "not_residential"
        }
    </script>


    <script>
        $(document).ready(() => {

            // $('#snipper').hide();

            $(document).on('click', '.fav-heart', function(e) {
                e.preventDefault();


                var data = $(this).attr('href');

                var self = this;
                // Save the reference
                $.ajax({
                    method: 'get',
                    url: data,
                    data: data,
                    async: true,

                    success: () => {
                        console.log("success");

                    },
                    complete: (data) => {
                        if (data.responseJSON.message == "remove") {
                            self.classList.remove("bg-danger");
                            self.classList.add("headings-post");
                            setTimeout(() => {
                                $(this).tooltip('hide').attr('data-original-title',
                                    'wishlist');
                            }, 500);
                            console.log("class removes");
                        } else if ((data.responseJSON.message == "success")) {
                            self.classList.add("bg-danger");
                            setTimeout(() => {
                                $(this).tooltip('hide').attr('data-original-title',
                                    'remove wishlist');
                            }, 500);

                        } else {
                            console.log("no classs applied");
                        }


                    }

                });

            });

            $("#subscribe-input").on("input", function() {
                // Print entered value in a div box

                if (!$(this).val()) {

                    $('#subscribe-message').text('email required');
                    $('#subscribe-message').css('color', 'red');

                } else {
                    $('#subscribe-message').text('');
                }

            });
            $(document).on('click', '#btn-subscribe', function(e) {
                e.preventDefault();
                if ($('#subscribe-input').val() == '') {
                    $('#subscribe-message').text('email required');
                    $('#subscribe-message').css('color', 'red');
                } else {


                    $('#subscribe-hide').hide();
                    $('#subscribe-message').text('Thanks for subscribing us');
                    $('#subscribe-message').addClass('color-primary');

                }
            });



        });
    </script>

    <script>
        $("#property_type").change(function() {

            $property_type = $("#property_type option:selected").val();

            getAreaFromCity($city);

        });
    </script>


    <script>
        $("#city").change(function() {

            //console.log("s");

            $city = $("#city option:selected").val();

            getAreaFromCity($city);

        });

        function getAreaFromCity(city = "city") {
            $.ajax({
                url: `{{ url('areas') }}/${city}`,
                success: function(res) {
                    //console.log(res);
                    $("#location").html(function() {
                        $allOption = "";
                        for ($i = 0; $i < res.length; $i++) {
                            $allOption += "<option value='" + res[$i].id + "'> " + res[$i].area +
                                " </option>";
                        }

                        return $allOption;
                    });
                }

            });

        }
        getAreaFromCity();
    </script>



    <script>
        $(document).ready(function() {

            $('#search2').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "search",
                    type: "GET",
                    data: {
                        'search2': query
                    },
                    success: function(data) {
                        $('#search_list').html(data);
                    }
                });
            });


            $("#search_list").on('click', 'p', function(event) {
                $('#search2').val(event.target.innerHTML)
            })
        });
    </script>
    <script>
        $('.select2').select2();
    </script>


    <script>
        $(document).ready(function() {
            $('.commercial').hide()
            $('.residential').hide()
            $('.property_type').click(function() {

                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);

                $(".box").not(targetBox).hide();

                $(targetBox).show();
            });
        });
    </script>



    <script>
        function myFunction() {

            const x = document.getElementById("property_type").value;
            console.log(x);
        }
    </script>

    <script>
        $(document).ready(function() {

            $('.commercial').hide()
            $('.residential').hide()
            $('.property_type').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                if (inputValue == "commercial") {

                    $(".res").not(targetBox).hide();
                    $(".com").not(targetBox).show();


                    var xyz = document.getElementById("ress").style.fontSize = "12px";
                    var xyz = document.getElementById("com").style.fontSize = "20px";

                } else {
                    $(".res").not(targetBox).show();
                    $(".com").not(targetBox).hide();
                    var xyz = document.getElementById("ress").style.fontSize = "20px";
                    var xyz = document.getElementById("com").style.fontSize = "12px";


                }

                $(targetBox).show();
            });
        });
    </script>
@endsection
 