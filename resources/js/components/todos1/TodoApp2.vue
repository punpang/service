<template>
  <section class="todoapp">
    <header class="header">
      <h1>todos</h1>
    </header>
    <new-todo></new-todo>
    <todo-list></todo-list>
  </section>
</template>
     <script>
import newTodo from "@/js/components/todos/NewTodo.vue";
import todoList from "@/js/components/todos/TodoList.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    newTodo,
    todoList,
  },
  name: "TodoApp",
  mounted() {
    window.Echo.channel("newTask").listen(".task-created", (e) => {
        
        this.$store.dispatch("pusher/GET_TODOS");
        //this.$store.commit("pusher/ADD_TODO", e.task);
      
      this.newTodo.title = "";
    });
    window.Echo.channel("taskRemoved").listen(".task-removed", (e) => {
        console.log(this.toRemove);
      this.$store.commit("pusher/DELETE_TODO", this.toRemove);
    });
  },
  computed: {
    ...mapGetters({newTodo : "pusher/newTodo"}),
    ...mapGetters({toRemove : "pusher/toRemove"}),

  },
};
</script>