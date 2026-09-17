<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/plugins/slick-1.8.1/slick/slick.min.js"></script>

<script defer type="text/javascript">
$('#blog .inner #blogposts-wrapper').slick({
  infinite: true,
  autoplay: true,
  autoplaySpeed: 6000,
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});


function backgroundMove(el, xMoveRatio = 1, yMoveRatio = 1) {
  el.addEventListener("mousemove", (e) => {
    el.style.backgroundPositionX = -e.offsetX * xMoveRatio + "px";
    el.style.backgroundPositionY = -e.offsetY * yMoveRatio + "px";
  });
}

/*
const el = document.querySelector("#intro");
backgroundMove(el, 0.2, 0.2);
*/

</script>