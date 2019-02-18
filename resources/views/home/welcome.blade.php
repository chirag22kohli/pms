@extends('layouts.home')

@section('content')

            <!-- Header
    ============================================= -->
           
            <!-- Slider #1
            ============================================= -->
            <section id="slider" class="section slider slider-2">
                <div class="slide--item bg-overlay bg-overlay-theme">
                    <div class="bg-section">
                        <img src="{{ asset('home/images/background/bg-1.jpg') }}" alt="background">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="slide--logo mt-100 hidden-xs wow fadeInUp" data-wow-duration="1s">
                                    <img src="{{ asset('home/images/logo/logo-light.png') }} " alt="logo hero">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 pt-100 wow fadeInUp" data-wow-duration="1s">
                                <div class="slide--headline">
                                    <h4 style="color:#fff;font-weight: 400;">Chap uses the latest technology on the market to transform your phone into a digital magic wand!</h4>
                                </div>
                                <div class="slide--bio"> Allowing you to have the best AR experience. </div>
                                <div class="slide--action cta">
                                    <a class="btn-hover" href="#"><img src="{{ asset('home/images/appstore.png') }}" alt="download appstore"></a>
                                    <a class="btn-hover" href="#"><img src="{{ asset('home/images/playstore.png') }} " alt="download playstore"></a>
                                </div>
                            </div>
                            <div class="slide--holder">
                                <img class="img-responsive pull-right" src="{{ asset('home/images/mockup/iphone-2.png') }} " alt="screens">
                            </div>
                        </div>
                        <!-- .row end -->
                    </div>
                    <!-- .container end -->
                </div>
                <!-- .slide-item end -->
            </section>
            <!-- #slider end -->

            <div class="clearfix pt-100 bg-white"></div>

            <!-- Feature #2
            ============================================= -->
            <section id="feature2" class="section feature feature-2 text-center bg-white">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-80 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title">Best AR Experience for you!</h2>
                                <p class="heading--desc"> Check out the features below and get ready for to experience a Brand New Reality!</p>
                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row mb-60">
                        <!-- Panel #1 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    <i class="lnr lnr-users"></i>
                                </div>
                                <div class="feature--content">
                                    <h3>Stay Connected</h3>
                                    <p>Chap impresses you with fully responsiveness and highly customization. We did it in combination of very clean and flexible design.</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->

                        <!-- Panel #2 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    <i class="lnr lnr-cog"></i>
                                </div>
                                <div class="feature--content">
                                    <h3>Manage Projects</h3>
                                    <p>Scan once and manage your projects hassle free.</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->

                        <!-- Panel #3 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    <i class="lnr lnr-lock"></i>
                                </div>
                                <div class="feature--content">
                                    <h3>Secure Data</h3>
                                    <p>Your data with us is secure and encrypted.</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <!-- Panel #4 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    <i class="lnr lnr-clock"></i>
                                </div>
                                <div class="feature--content">
                                    <h3>Save your Contacts/Events</h3>
                                    <p>Scan the AR experience, Save your contacts and events within the application and access them anytime.</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->

                        <!-- Panel #5 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    <i class="lnr lnr-star"></i>
                                </div>
                                <div class="feature--content">
                                    <h3>AR Experience</h3>
                                    <p>Enjoy Videos, Audio, Social Sharing etc all with the best AR experience.</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->

                        <!-- Panel #6 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    <i class="lnr lnr-bug"></i>
                                </div>
                                <div class="feature--content">
                                    <h3>Free Updates</h3>
                                    <p>We are working hard to give our users the best of AR experience by providing the free updates all for you. </p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container end -->
            </section>
            <!-- #feature2 end -->

            <!-- Feature #3
            ============================================= -->
            <section id="feature3" class="section feature feature-left feature-left-circle">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title">How does it work ?</h2>

                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="center-block text-center mb-100 wow fadeInUp" data-wow-duration="1s">
                                <img src="{{ asset('home/images/mockup/iphone.png') }} " alt="screenshots">
                            </div>
                        </div>
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <!-- Panel #1 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    1
                                </div>
                                <div class="feature--content">
                                    <h3>Download Chap</h3>
                                    <p>Download the Chap from your Playstore or Appstore. Its free!</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->

                        <!-- Panel #2 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    2
                                </div>
                                <div class="feature--content">
                                    <h3>Install & sign up</h3>
                                    <p>Simply signup with easy steps and start scanning for AR experience!</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->

                        <!-- Panel #3 -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="feature-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="feature--icon">
                                    3
                                </div>
                                <div class="feature--content">
                                    <h3>Manage Projects,Contacts,Events and much more!</h3>
                                    <p>Manage Projects,Contacts,Events and much more all within the application.</p>
                                </div>
                            </div>
                            <!-- .feature-panel end -->
                        </div>
                        <!-- .col-md-4 end -->
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container end -->
            </section>
            <!-- #feature3 end -->

            <!-- Video
            ============================================= -->
            <section id="video" class="section video bg-overlay bg-overlay-theme bg-parallex">
                <div class="bg-section">
                    <img src="{{ asset('home/images/background/bg-2.jpg') }} " alt="background">
                </div>
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title text-white">Watch a demo</h2>
                                <p class="heading--desc text-white">Let us Show you!</p>
                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center wow fadeInUp" data-wow-duration="1s">
                            <div class="video-ipad-holder">
                                <iframe src="https://player.vimeo.com/video/58363288?color=ffffff&title=0&byline=0&portrait=0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- #video end -->

            <!-- Screenshots ============================================= -->
            <section id="screenshots" class="section screenshots">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title">Screenshots</h2>
                                <p class="heading--desc">we shows only the best websites, portfolios ans landing pages built completely with passion, simplicity & creativity !</p>
                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="carousel" data-slide="5" data-slide-res="2" data-autoplay="true" data-nav="false" data-dots="false" data-space="30" data-loop="true" data-speed="1000">
                                <!-- screenshot #1 -->
                                <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/1.jpg') }} " alt="client">
                                </div>

                                <!-- screenshot #2 -->
                                <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/2.jpg') }}"  alt="client">
                                </div>

                                <!-- screenshot #3 -->
                                <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/3.jpg') }}"  alt="client">
                                </div>

                                <!-- screenshot #4 -->
                                <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/4.jpg') }} " alt="client">
                                </div>
                                 <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/5.jpg') }} " alt="client">
                                </div>
                                 <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/6.jpg') }} " alt="client">
                                </div>
                                 <div class="screenshot">
                                    <img class="center-block" src="{{ asset('home/images/screenshots/7.jpg') }} " alt="client">
                                </div>
                            </div>
                        </div>
                        <!-- .col-md-12 end -->
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container End -->
            </section>
            <!-- #screenshots End-->

            <!-- reviews
    ============================================= -->
            <section id="reviews" class="section reviews bg-white">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title">User reviews</h2>
                                <p class="heading--desc">we shows only the best websites, portfolios ans landing pages built completely with passion, simplicity & creativity !</p>
                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <!--  Testimonial #1  -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="testimonial-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="testimonial-body">
                                    <div class="testimonial--body">
                                        <p>We have worked with appify.As we have grown and evolved, appfiy has created all of our profit.What I value most about our relationship is that appfiy knows us and our business.</p>
                                    </div>
                                    <div class="testimonial--meta">
                                        <div class="testimonial--author pull-left">
                                            <h5>Mark Smith</h5>
                                        </div>
                                        <div class="testimonial--rating pull-right">
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star-half-full"></i>
                                            <i class=" fa fa-star-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Testimonial #2  -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="testimonial-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="testimonial-body">
                                    <div class="testimonial--body">
                                        <p>We have worked with Chap.As we have grown and evolved, appfiy has created all of our profit.What I value most about our relationship is that appfiy knows us and our business.</p>
                                    </div>
                                    <div class="testimonial--meta">
                                        <div class="testimonial--author pull-left">
                                            <h5>Jessy Arthur</h5>
                                        </div>
                                        <div class="testimonial--rating pull-right">
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Testimonial #3  -->
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="testimonial-panel wow fadeInUp" data-wow-duration="1s">
                                <div class="testimonial-body">
                                    <div class="testimonial--body">
                                        <p>We have worked with Chap.As we have grown and evolved, appfiy has created all of our profit.What I value most about our relationship is that appfiy knows us and our business.</p>
                                    </div>
                                    <div class="testimonial--meta">
                                        <div class="testimonial--author pull-left">
                                            <h5>Nicole Jonson</h5>
                                        </div>
                                        <div class="testimonial--rating pull-right">
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star"></i>
                                            <i class=" fa fa-star-half-full"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container End -->
            </section>
            <!-- #reviews End-->

            <!-- Pricing Table #1
            ============================================= -->
            <?php if (count($plans) > 0) { ?>
                <section id="pricing" class="section pricing pricing-1 bg-overlay bg-overlay-theme bg-parallex">
                    <div class="bg-section">
                        <img src="{{ asset('home/images/background/bg-4.jpg') }}" alt="background">
                    </div>
                    <div class="container">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                                <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                                    <h2 class="heading--title text-white">Pricing plans</h2>
                                    <p class="heading--desc text-white">Pricing plans all made for your needs!</p>
                                </div>
                            </div>
                            <!-- .col-md-6 end -->
                        </div>
                        <!-- .row end -->
                        <div class=" row carousel" data-slide="3" data-slide-res="2" data-autoplay="true" data-nav="false" data-dots="false" data-space="30" data-loop="true" data-speed="10000">
                            <!-- Pricing Packge #1
                            ============================================= -->
                            <?php foreach ($plans as $plan) { ?>
                                <div class=" col-xs-12 col-sm-12 col-md-12 price-table wow fadeInUp" data-wow-duration="1s">
                                    <div class="pricing-panel">
                                        <!--  Pricing heading  -->
                                        <div class="pricing--heading text--center">
                                            <h4><?= $plan->name ?></h4>
                                            <div class="pricing--heading">
                                                <p>$<?= $plan->price ?></p>
                                                <div class="pricing--desc">
                                                    <ul class="list-unstyled">
                                                        <?php if ($plan->type == 'size') { ?>
                                                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $plan->max_trackers }} MB Storage</li> 

                                                        <?php } else { ?>

                                                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $plan->max_trackers }} Trackers</li> 

                                                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> Unlimited Storage</li> 

                                                        <?php } ?>
                                                              <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> Reports</li>
                                                              <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> True AR Experience</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  Pricing body  -->
                                        <div class="pricing--body">
                                            <a class="btn btn--white btn--bordered" href="signup/<?= base64_encode($plan->id)?>">Get Started</a>
                                        </div>
                                        <!--  Pricing Body  -->
                                    </div>

                                </div>
                            <?php } ?>
                            <!-- .pricing-table End -->


                            <!-- .pricing-table End -->
                        </div>
                        <!-- .row end -->
                        <div style="text-align:center">
     <a class="btn btn--white btn--bordered" href="{{ url('/viewPlans') }}">View All Plans</a>
</div>​
                     
                    </div>
                    <!-- .container end -->
                </section>
            <?php } ?>
            <!-- #pricing1 end -->

            <!-- CTA #1
            ============================================= -->
            <section id="cta" class="section cta text-center pb-0">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-50 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title">Download & install appy now</h2>
                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-100 wow fadeInUp" data-wow-duration="1s">
                            <a class="btn-hover" href="#"><img src="{{ asset('home/images/appstore.png') }} " alt="download appstore"></a>
                            <a class="btn-hover" href="#"><img src="{{ asset('home/images/playstore.png') }} " alt="download playstore"></a>
                        </div>
                        <!-- .col-md-12 end -->
                        <div class="col-xs-12 col-sm-12 col-md-12 wow fadeInUp" data-wow-duration="1s">
                            <img src="{{ asset('home/images/mockup/2-layers.png') }} " alt="mockup"/>
                            <!-- .col-md-12 end -->
                        </div>
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container end -->
            </section>
            <!-- #cta1 end -->

            <!-- Newsletter #1
            ============================================= -->
            <section id="newsletter" class="section newsletter text-center bg-overlay bg-overlay-theme">
                <div class="bg-section">
                    <img src="{{ asset('home/images/background/bg-3.jpg') }}" alt="Background"/>
                </div>
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                            <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                                <h2 class="heading--title text-white">Subscribe to get updates</h2>
                                <p class="heading--desc text-white">we shows only the best websites, portfolios ans landing pages built completely with passion, simplicity & creativity !</p>
                            </div>
                        </div>
                        <!-- .col-md-6 end -->
                    </div>
                    <!-- .row end -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                            <form class="mb-0 form-action wow fadeInUp" data-wow-duration="1s">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="E-mail address">
                                    <span class="input-group-btn">
                                        <input type="submit" class="btn btn--primary" value="Subscribe" name="submit">
                                    </span>
                                </div>
                                <!-- .input-group end -->
                            </form>
                        </div>
                        <!-- .col-md-12 end -->
                    </div>
                    <!-- .row end -->
                </div>
                <!-- .container end -->
            </section>
            <!-- #newsletter end -->
@endsection
