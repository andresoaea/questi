<template>
  <div>
    <ul class="nav nav-tabs questions-list-nav-tabs">
      <li class="nav-item">
        <router-link to="/" class="nav-link" exact>Recent questions</router-link>
      </li>
      <li class="nav-item">
        <!-- <a class="nav-link" :href="`${siteUrl}/most-answered`">Most answered</a> -->
        <router-link to="/most-answered" class="nav-link">Most answered</router-link>
      </li>
      <li class="nav-item">
        <router-link to="/without-answer" class="nav-link">Without answer</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import bus from "../main.js";

export default {
  name: "questions-nav-tabs"
};
</script>