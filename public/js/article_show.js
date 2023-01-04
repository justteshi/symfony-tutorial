$(document).ready(function () {
    $(".js-like-article").on('click',function (e){
        e.preventDefault();

        let $link = $(e.currentTarget);
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart')

        $('.js-like-article-count').html('Test')
    })
});
