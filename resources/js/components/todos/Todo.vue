<template>
  <li class="todo" :class="{ completed: todo.completed }">
    <div class="view">
      <input type="checkbox" v-model="todo.completed" class="toggle" />
      <label>{{ todo.id }} ::: {{ todo.title }}</label>
      <v-btn  color="error" small @click="removeTodo(todo)">X</v-btn>
    </div>
  </li>
</template>
    <script>
export default {
  name: "Todo",
  props: ["todo"],

  methods: {
    removeTodo(todo) {
      this.$store.commit("pusher/CACHE_REMOVED", todo);
      this.$store.dispatch("pusher/DELETE_TODO", todo);
    },
  },
};
</script>