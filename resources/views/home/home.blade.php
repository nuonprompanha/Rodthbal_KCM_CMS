@extends('layouts.home.home_master')
@section('title', 'ក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ')
@section('content')
    <main class="container-fluid p-0 m-0">
        <!-- Carousel -->
        <div id="carouselExampleDark" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4"
                    aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="{{asset('uploads/images/rev_hong_san.png')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="kh-title carousel-bg-title">ព្រឹទិ្ធបូជាចារ្យ ហុង សន</h5>
                        <p class="kh-content carousel-bg-text">គ្រូគង្វាលច្បង និងជាស្ថាបនិក ក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="{{asset('uploads/images/women_group.png')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="kh-title carousel-bg-title">ក្រុមស្ត្រី</h5>
                        <p class="kh-content carousel-bg-text">ព័ន្ធកិច្ចក្រុមស្ដ្រីនៃក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ (សួរសុខទុក្ខ និងអធិស្ឋាន)</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('uploads/images/rev_hong_chan_narom.png')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="kh-title carousel-bg-title">ព្រឹទិ្ធបូជាចារ្យ ហុង ចាន់ណារុំ</h5>
                        <p class="kh-content carousel-bg-text">គ្រូគង្វាល និងជាស្ថាបនិក មជ្ឍមណ្ឌល និមិត្តសន្តិភាព និងជាអ្នកដឹកនាំព័ន្ធកិច្ចក្រុមជំនុំ</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('uploads/images/youth.png')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="kh-title carousel-bg-title">ព័ន្ធកិច្ចក្រុមយុវជន</h5>
                        <p class="kh-content carousel-bg-text">កម្មវិធីថ្វាយបង្គំ និងព័ន្ធកិច្ចចំបងផ្សេងៗក្នុងក្រុមជំនុំ</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('uploads/images/other_mission.png')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="kh-title carousel-bg-title">ព័ន្ធកិច្ចក្រុមជំនុំ</h5>
                        <p class="kh-content carousel-bg-text">ការចូលរួម និងរួមចំណែកក្នុងសកម្មភាពផ្សេងៗនៃក្រុមជំនុំ</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    <!-- End Carousel -->
     <!-- Welcome Message -->
     <div class="container">
        <div class="row">
            <div class="col-12 text-center py-3">
                <h2 class="kh-header home-color-warning">សូមស្វាគមន៍</h2>
                <h5 class="kh-title home-color-primary">ទំព័រផ្លុវការនៃក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ</h5>
            </div>
        </div>
     </div>
     <!-- End Welcome Message -->
    </main>
@endsection
