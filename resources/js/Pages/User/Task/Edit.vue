<script setup>
import { ref, watch } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { router, useForm } from '@inertiajs/vue3'

const props = defineProps({
  task: Object,
  goals: Object,
  targets: Object
})

const goal_id = ref(props.task.goal.id)
const targets = ref(props.targets)

watch(goal_id, value => {
  axios.get(route('user.get_targets', { goal_id: value })).then(res => {
    targets.value = res.data
  })
})

const form = useForm({
  target_id: props.task.target_id,
  name: props.task.name,
  description: props.task.description,
  status: props.task.status,
  priority: props.task.priority,
  due_date: props.task.due_date
})
</script>

<template>
  <Head title="Edit Task" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <form @submit.prevent="form.put(route('user.tasks.update', task.id))" class="space-y-6 max-w-xl">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <InputLabel for="goal_id" value="Select Goal" />

                <select
                  name="goal_id"
                  id="goal_id"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 cursor-pointer"
                  v-model="goal_id"
                >
                  <option v-for="goal in goals" :value="goal.id">{{ goal.name }}</option>
                </select>

                <InputError class="mt-2" :message="form.errors.goal_id" />
              </div>
              <div>
                <InputLabel for="target_id" value="Select Target" />

                <select
                  name="target_id"
                  id="target_id"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 cursor-pointer"
                  v-model="form.target_id"
                  :class="{ 'bg-gray-200': !targets }"
                  :disabled="!targets"
                >
                  <option v-for="target in targets" :value="target.id">{{ target.name }}</option>
                </select>

                <InputError class="mt-2" :message="form.errors.target_id" />
              </div>
            </div>

            <div>
              <InputLabel for="name" value="Name" />

              <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />

              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
              <InputLabel for="description" value="Description" />

              <textarea
                id="description"
                name="description"
                cols="30"
                rows="5"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                v-model="form.description"
              ></textarea>

              <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <InputLabel for="status" value="Select Status" />

                <select
                  name="status"
                  id="status"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 cursor-pointer"
                  v-model="form.status"
                >
                  <option value="todo">Todo</option>
                  <option value="in_progress">In Progress</option>
                  <option value="done">Done</option>
                </select>

                <InputError class="mt-2" :message="form.errors.status" />
              </div>
              <div>
                <InputLabel for="priority" value="Select Priority" />

                <select
                  name="priority"
                  id="priority"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 cursor-pointer"
                  v-model="form.priority"
                >
                  <option value="low">Low</option>
                  <option value="medium">Medium</option>
                  <option value="high">High</option>
                </select>

                <InputError class="mt-2" :message="form.errors.priority" />
              </div>
            </div>

            <div>
              <InputLabel for="due_date" value="Due Date" />

              <TextInput id="due_date" type="date" class="mt-1 block w-full" v-model="form.due_date" />

              <InputError class="mt-2" :message="form.errors.due_date" />
            </div>

            <div class="flex items-center gap-4">
              <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

              <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
              >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
              </Transition>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
