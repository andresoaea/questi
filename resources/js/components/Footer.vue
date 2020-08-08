<template>
  <footer class="main-footer">
    <p class="copyright-text">&copy; 2020 Questi - Q&A Platform</p>
  </footer>
</template>

<script>
export default {
  mounted() {
    setTimeout(() => {
      $(".questi-preloader").fadeOut(500);
    }, 500);

    // const mainPreloader = document.querySelectorAll(".questi-preloader")[0];
    // if (mainPreloader) {
    //   mainPreloader.parentNode.removeChild(mainPreloader);
    // }
  }
};
</script>