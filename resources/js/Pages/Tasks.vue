<script setup>
import { Head, Link } from '@inertiajs/vue3';
import IyataLayout from '@/Layouts/IyataLayout.vue';
import { reactive, ref, onMounted } from 'vue';

const tasks = ref([]);

onMounted(async () => {
    getTasks();
});

async function getTasks(){
    const response = await axios.get('/api/task');

    console.log(response.data.tasks);

    let respTasks = response.data.tasks;

    respTasks = respTasks.map(task => {
        task.badge_priority = getBadgePriority(task.prioridad);
        task.badge_status = getBadgeStatus(task.estado);

        return task;
    });

    tasks.value = respTasks;

    // console.log(tasks.value);
}

function getBadgePriority(priority) {
    switch (priority) {
        case 'Alta':
            return 'badge-priority-high';
        case 'Media':
            return 'badge-priority-medium';
        case 'Baja':
            return 'badge-priority-low';
        default:
            return '';
    }
};

function getBadgeStatus(status) {
    switch (status) {
        case 'Pendiente':
            return 'badge-status-pending';
        case 'Completada':
            return 'badge-status-completed';
        default:
            return '';
    }
};

</script>

<template>

    <IyataLayout>
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">
                            <i class="fas fa-list me-2"></i>Mis Tareas
                        </h2>
                        <Link
                            href="/task/create"
                            class="btn btn-primary"
                            preserve-scroll
                        >
                            <i class="fas fa-plus me-1"></i>Nueva Tarea
                        </Link>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <select class="form-select">
                                <option>Todas las tareas</option>
                                <option>Pendientes</option>
                                <option>Completadas</option>
                                <option>Vencidas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select">
                                <option>Todas las prioridades</option>
                                <option>Alta</option>
                                <option>Media</option>
                                <option>Baja</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Buscar tareas...">
                        </div>
                    </div>

                    <!-- Lista de Tareas -->
                    <div v-for="task in tasks" class="todo-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="todo-title">{{ task.titulo }}</div>
                                <div class="todo-description">{{ task.descripcion }}</div>
                                <div class="todo-meta">
                                    <span class="badge badge-priority-high me-2">{{ task.prioridad }}</span>
                                    <span class="badge badge-status-pending me-2">{{ task.estado }}</span>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </IyataLayout>
</template>