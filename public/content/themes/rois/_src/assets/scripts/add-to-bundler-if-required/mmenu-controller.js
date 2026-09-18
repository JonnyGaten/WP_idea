jQuery(function ($) {
    $('.nav--trigger').on('click',function(e){
        e.preventDefault();
    });
        $("#the-mmmenu").mmenu({
            navbar: [{ add: false }],
            navbars: [
            {
                "position": "bottom",
                "content": [
                    '<footer class="px-3 px-lg-5"><div class="container-fluid"><div class="row align-items-center justify-content-between"><div class="col-12 col-md-4 col-lg-4 text-left"><p>&#169; 2020 Metrics Contract Services</p></div><div class="col-12 col-md-auto text-left"><a href="https://linkedin.com" target="_blank">LinkedIn</div><div class="col-12 col-md-auto col-lg-6 text-left text-md-right"><ul class="mobile-footer"><li><a href="#">Mayne Pharma</a></li><li><a href="/privacy-policy/">Privacy Policy</a></li><li><a href="/terms-and-conditions/">Terms and Conditions</a></li></ul></div></div></div></footer>'
                ]

            },
            {
                "position": "top",
                "content": [
                    '<a href="#mm-0" aria-owns="mm-0"class="nav--trigger close font--heading small d-inline-flex align-items-center justify-content-center">close</a>'
                ]

            }
            ],
        "extensions": [
            "fullscreen",
            "position-right",        
            "position-front",
            "listview-justify"

        ]
    });
});