<template>
    <div>
        <h1>Todo App</h1>

        <div class="row">
            <div class="col">
                <ul class="list-group" id="usual-todos">
                    <li class="list-group-item">
                        <h3>Todos ({{usualTodos.length}})</h3>
                    </li>
                    <todo v-for="todo in usualTodos"
                          :key="todo.id"
                          :todo="todo"
                          @complete="complete"
                          @urgent="urgent"
                          @update="update"
                          @delete="deleteTodo"
                    ></todo>
                    <create-todo @create="create" />
                </ul>
            </div>
            <div class="col">
                <ul class="list-group" id="urgent-todos">
                    <li class="list-group-item">
                        <h3>Urgent Todos <span :class="[urgentTodos.length >= 3 ? 'urgent' : '']">({{urgentTodos.length}})</span></h3>
                    </li>
                    <todo v-for="todo in urgentTodos"
                          :key="todo.id"
                          :todo="todo"
                          @complete="complete"
                          @urgent="urgent"
                          @update="update"
                          @delete="deleteTodo"
                    ></todo>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Methods from '../mixins/methods';
    import Todo from './Todo';
    import CreateTodo from './CreateTodo';

    export default {
        mixins: [Methods],

        props: {
            todos: {
                type: String,
                required: true,
                default: ''
            }
        },

        data(){
            return {
                todoList: [],
                usualTodos: [],
                urgentTodos: []
            }
        },

        methods: {
            /**
             * separates todos into two groups: usual and urgent
             **/
            updateLists(){
                if (this.todoList.length) {
                    this.usualTodos = this.todoList.filter(todo => !todo.urgent).sort(todo => todo.completed ? 1 : -1);
                    this.urgentTodos = this.todoList.filter(todo => todo.urgent).sort(todo => todo.completed ? 1 : -1);
                } else {
                    this.usualTodos = [];
                    this.urgentTodos = [];
                }
            },
            /**
             * toggle todo complete
             * @param todo
             */
            complete(todo) {
                this.todoList = this.todoList.map(t => {
                    if (t.id === todo.id) {
                        t.completed = !t.completed;
                    }

                    return t;
                });

                this.$http.post(this.route('todo.update', todo.id), todo).then(() => {
                    this.updateLists();
                });
            },
            /**
             * toggle todo urgent
             * @param todo
             */
            urgent(todo){
                this.todoList = this.todoList.map(t => {
                    if (t.id === todo.id) {
                        t.urgent = !t.urgent;
                    }

                    return t;
                });

                this.$http.post(this.route('todo.update', todo.id), todo).then(({data}) => {
                    if (!data.error) {
                        this.updateLists();
                    } else {
                        toastr.error(data.message);
                    }
                });
            },
            /**
             * update todo text
             * @param todo
             * @param text
             */
            update(todo, text) {
                this.todoList = this.todoList.map(t => {
                    if (t.id === todo.id) {
                        t.text = text;
                    }

                    return t;
                });

                this.$http.post(this.route('todo.update', todo.id), todo).then(({data}) => {
                    if (!data.error) {
                        this.updateLists();
                    } else {
                        toastr.error(data.message);
                    }
                });
            },
            /**
             * delete todo
             * @param todo
             */
            deleteTodo(todo){
                let index = this.todoList.findIndex(t => t.id === todo.id);

                if (index > -1) {
                    this.$http.post(this.route('todo.delete', todo.id), todo).then(() => {
                        this.$delete(this.todoList, index);
                        this.updateLists();
                    });
                }
            },
            /**
             * Creating todo
             * @param todo
             */
            create(todo){
                this.$http.post(this.route('todo.create'), todo).then(({data}) => {
                    if (!data.error) {
                        this.todoList.push(data.todo);

                        this.updateLists();
                    } else {
                        toastr.error(data.message);
                    }
                });
            }
        },

        mounted(){
            if (typeof this.todos === "string" && this.todos.length) {
                this.todoList = JSON.parse(this.todos);

                this.updateLists();
            } else {
                this.todoList = [];
            }
        },

        components: {
            todo: Todo,
            createTodo: CreateTodo
        }
    }
</script>

<style lang="scss" scoped>
    .urgent {
        color: orangered !important;
    }
</style>