<template>
  <div class="row" v-if="widgetData.length !== 0">
    <div v-for="question in widgetData" class="col-12">
      <div class="row question">
        <div class="col-10">{{ question.title }}</div>
        <div class="col-2">
          <span class="mr0">
            <i aria-hidden="true" class="like fa fa-thumbs-o-up"></i>
            {{ JSON.parse(question.reactions).like.length }}
          </span>
        </div>
      </div>
    </div>
  </div>
  <div v-else>No appreciated questions yet</div>
</template>

<script>
export default {
  props: ["widgetData"]
};
</script>