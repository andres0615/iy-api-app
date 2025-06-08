<script setup>
import { Head, Link } from '@inertiajs/vue3';
import IyataLayout from '@/Layouts/IyataLayout.vue';
import { reactive, ref, onMounted } from 'vue';

const task = reactive({
    titulo: '',
    descripcion: '',
    prioridad: ''
});

function getBadgePriority(priority) {
    switch (priority) {
        case 'ALTA':
            return 'badge-priority-high';
        case 'MEDIA':
            return 'badge-priority-medium';
        case 'BAJA':
            return 'badge-priority-low';
        default:
            return '';
    }
};

function getPriorityLabel(priority) {
    // console.log(priority);
    switch (priority) {
        case 'ALTA':
            return 'Alta';
        case 'MEDIA':
            return 'Media';
        case 'BAJA':
            return 'Baja';
        default:
            return '';
    }
};

async function saveTask(){
    let response = await axios.post('/api/task', task);

    if(response.data.success){
        // Redirect to tasks page
        Inertia.visit('/');
    } else {
        // Handle error
        console.error('Error al guardar la tarea:', response.data.message);
    }
}

</script>

<template>
    <IyataLayout>
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-plus me-2"></i>Nueva Tarea
                    </h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="taskTitle" class="form-label">Título de la tarea</label>
                                    <input type="text" class="form-control" v-model="task.titulo" id="taskTitle" placeholder="Ingresa el título de la tarea">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="taskDescription" class="form-label">Descripción</label>
                                    <textarea class="form-control" v-model="task.descripcion" id="taskDescription" rows="4" placeholder="Describe los detalles de la tarea"></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="taskPriority" class="form-label">Prioridad</label>
                                            <select class="form-select" id="taskPriority" v-model="task.prioridad">
                                                <option value="">Seleccionar prioridad</option>
                                                <option value="ALTA">Alta</option>
                                                <option value="MEDIA">Media</option>
                                                <option value="BAJA">Baja</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Vista previa</h5>
                                        <div class="todo-item">
                                            <div class="todo-title"> {{ (task.titulo)?task.titulo:'Título de ejemplo' }} </div>
                                            <div class="todo-description" v-if="task.descripcion">{{ task.descripcion }}</div>
                                            <div class="todo-description" v-else>Esta es una descripción de ejemplo para mostrar cómo se verá la tarea.</div>
                                            <div class="todo-meta">
                                                <span class="badge badge-status-pending me-2" >Pendiente</span>
                                                <span :class="'badge ' + getBadgePriority(task.prioridad)" v-if="task.prioridad">{{ getPriorityLabel(task.prioridad) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <Link
                                href="/"
                                class="btn btn-outline-primary"
                                :class="{ 'active': $page.url === '/' }"
                                preserve-scroll
                                preserve-state
                            >
                                <i class="fas fa-arrow-left me-1"></i>Volver a tareas
                            </Link>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" @click="saveTask()">
                                    <i class="fas fa-save me-1"></i>Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </IyataLayout>
</template>