<template>
    <li class="d-flex align-items-center list-group-item todo cursor-pointer"
        v-if="Object.keys(todo).length > 0 && todo.id"
        :id="`list-item-${todo.id}`"
        @click.stop.prevent="activate($event)"
        :class="[active ? 'bg-grey' : '']"
    >
        <div>
            <button class="btn border-0 flex-grow-1 text-left min-width-180"
                    :class="[todo.completed ? 'completed' : '']"
                    v-if="!editing"
                    @click="$emit('complete', todo)"
            >
                {{todo.text}}
            </button>
            <form class="flex-grow-1 d-inline-block" @submit.prevent="updateTodo" v-else>
                <input type="text" class="form-control" v-model="text" ref="newTodo">
            </form>
            <button class="btn btn-outline-primary ml-1 border-0" @click.prevent="updateTodo">
                <i class="fa fa-edit"></i>
            </button>
            <transition name="slide" >
                <div class="d-inline-block" v-if="active">
                    <button class="btn btn-outline-primary ml-1 border-0" @click.prevent="$emit('complete', todo)">
                        <i class="fa" :class="[todo.completed ? 'fa-times' : 'fa-check']"></i>
                    </button>
                    <button class="btn btn-outline-primary ml-1 border-0" @click.prevent="$emit('urgent', todo)">
                        <i class="fa" :class="[todo.urgent ? 'fa-fire-extinguisher' : 'fa-fire']" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-outline-primary ml-1 border-0 text-danger" @click.prevent="$emit('delete',todo)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </transition>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            todo: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                editing: false,
                text: ''
            }
        },
        methods: {
            /**
             * update todo
             */
            updateTodo(){
                if (this.editing) {
                    this.editing = false;
                    if (this.text !== this.todo.text) {
                        this.$emit('update', this.todo, this.text);
                    }
                } else {
                    this.text = this.todo.text;
                    this.editing = true;

                    this.$nextTick(() => this.$refs.newTodo.focus());
                }
            },
            /**
             * if this todo activated - toggle it
             * if not - make it activated
             */
            activate(e){
                e.preventDefault();
                e.stopPropagation();

                let li = document.querySelector(`#list-item-${this.todo.id}`);

                if (e.target !== li) return;

                let todo = this.todo;

                if (this.active) {
                    this.$store.dispatch('setActive', null);
                } else {
                    this.$store.dispatch('setActive', todo);
                }
            }
        },
        computed: {
            active(){
                return this.$store.getters.active && this.$store.getters.active === this.todo;
            }
        }
    }
</script>

<style scoped>
    .completed {
        text-decoration: line-through !important;
    }

    .slide-leave-active,
    .slide-enter-active {
        transition: all 0.3s ease;
    }
    .slide-enter {
        transform: translateY(100%);
    }
    .slide-leave-to {
        transform: translateY(100%);
    }

    .bg-grey {
        background-color: #E8E9EB !important;
    }

    .cursor-pointer {
        cursor: pointer !important;
    }

    .todo {
        overflow: hidden !important;
    }

    .min-width-180 {
        min-width: 180px;
    }
</style>