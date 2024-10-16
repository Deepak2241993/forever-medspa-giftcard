@extends('layouts.front_product')
@section('body')
@push('css')
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background: url('{{url('/uploads/FOREVER-MEDSPA/BG.jpg')}}') no-repeat center center fixed;
    background-size: cover;
    color: #333;
    position: relative;
}
/* Adding background overlay with opacity */
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Dark layer with 60% opacity */
    z-index: 1; /* Behind content */
}
.form_layer {
    position: relative;
    z-index: 2; /* Above the background layer */
    background: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
    padding: 20px;
    margin: 50px auto;
    max-width: 800px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}
.terms {
    margin-top: 30px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 15px;
    border-radius: 8px;
}
ul {
    margin-left: 30px;
}

.footer-box{
    z-index: 2; 
}

@media screen and (max-width: 768px) {
    .form_layer {
        margin: 20px;
        padding: 15px;
    }
    .form_layer h2{
            font-size: 30px;
            margin-top: 10px;
    }
}
@endpush

@section('body')
<!-- Body main wrapper start -->
<main>

    <!-- Breadcrumb area start  -->
    {{-- <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA/Slide_4.jpg')}}"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Referral</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><span><a href="{{url('/')}}">Home</a></span></li>
                                    <li><span>Referral</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Breadcrumb area end -->

    <!-- Product details area start -->
    <div class="product__details-area section-space-medium">
        <div class="container">
            <div class="form_layer">
                <h2 class="mb-4 text-center">Patient Referral Form</h2>
                <form action="submit_referral.php" method="POST" class="form-layer">
                    <!-- Referring Patient's Details -->
                    <h3>Referring Patient's Information</h3>

                    <label for="referring_name">Name</label>
                    <input type="text" id="referring_name" name="referring_name" required>

                    <label for="referring_email">Email</label>
                    <input type="email" id="referring_email" name="referring_email" required>

                    <label for="referring_phone">Phone</label>
                    <input type="tel" id="referring_phone" name="referring_phone" required>

                    <!-- Referred Patient's Details -->
                    <h3 class="mt-4">Referred Patient's Information</h3>

                    <label for="referred_name">Name</label>
                    <input type="text" id="referred_name" name="referred_name" required>

                    <label for="referred_email">Email</label>
                    <input type="email" id="referred_email" name="referred_email" required>

                    <label for="referred_phone">Phone</label>
                    <input type="tel" id="referred_phone" name="referred_phone" required>

                    <!-- Additional Information -->
                    <label for="comments">Additional Comments</label>
                    <textarea id="comments" name="comments" rows="4"></textarea>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit Referral</button>
                </form>

                <!-- Terms of Referral -->
                <div class="terms mt-4">
                    <h3>Terms of Referral</h3>
                    <ul>
                        <li>The referring patient must have been treated by our clinic in the past.</li>
                        <li>The referred patient must be a new patient to our clinic.</li>
                        <li>By submitting this form, you agree to share the referral information with our clinic.</li>
                        <li>All information will be kept confidential according to privacy laws.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Product details area end -->

</main>
<!-- Body main wrapper end -->
@endsection

@push('footerscript')
@endpush
