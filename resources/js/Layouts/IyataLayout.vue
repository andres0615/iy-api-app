<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
// const flash = computed(() => page.props.flash || {})
const success = computed(() => page.props.success || '');

const props = defineProps({
  success: String
})

console.log(props);
console.log(page);

</script>

<template>
    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <Link
                    href="/"
                    class="navbar-brand"
                    preserve-scroll
                >
                    <i class="fas fa-tasks me-2"></i>TodoApp
                </Link>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <Link
                                href="/"
                                class="nav-link"
                                :class="{ 'active': $page.url === '/' }"
                                preserve-scroll
                            >
                                <i class="fas fa-list me-1"></i>Tareas
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link
                                :href="route('task.create')"
                                class="nav-link"
                                :class="{ 'active': $page.url === '/task/create' }"
                                preserve-scroll
                            >
                                <i class="fas fa-plus me-1"></i>Nueva Tarea
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-container">
            <div class="container">
                <div v-if="success" class="alert alert-success">
                    {{ success }}
                </div>
                <transition name="fade" mode="out-in">
                    <slot />
                </transition>
            </div>
        </div>
</template>