<template>
  <ul class="todo-list">
    <todo v-for="todo in todos" :todo="todo" :key="todo.id" />
  </ul>
</template>
    
    <script>
import { mapGetters } from "vuex";
import todo from "@/js/components/todos/Todo";
export default {
  components: {
    todo,
  },
  name: "TodoList",
  mounted() {
    this.$store.dispatch("pusher/GET_TODOS",this.$route.params.id);
  },
  computed: {
    ...mapGetters({todos : "pusher/todos"}),
  },
};
</script>