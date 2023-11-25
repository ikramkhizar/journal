<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import InputError from "@/Components/InputError.vue"
import InputLabel from "@/Components/InputLabel.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"
import TextInput from "@/Components/TextInput.vue"
import { useForm } from "@inertiajs/vue3"

defineProps({
  goals: Object
})

const form = useForm({
  goal_id: "",
  name: "",
  type: ""
})
</script>

<template>
  <Head title="Add Target" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Target</h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <form @submit.prevent="form.post(route('user.targets.store'))" class="space-y-6 max-w-xl">
            <div>
              <InputLabel for="goal_id" value="Select Goal" />

              <select
                name="goal_id"
                id="goal_id"
                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 cursor-pointer"
                v-model="form.goal_id"
              >
                <option v-for="goal in goals" :value="goal.id">{{ goal.name }}</option>
              </select>

              <InputError class="mt-2" :message="form.errors.goal_id" />
            </div>

            <div>
              <InputLabel for="name" value="Name" />

              <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />

              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
              <InputLabel for="type" value="Select Type" />

              <select
                name="type"
                id="type"
                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 cursor-pointer"
                v-model="form.type"
              >
                <option value="number">Number</option>
                <option value="boolean">Boolean</option>
                <option value="currency">Currency</option>
                <option value="tasks">Tasks</option>
              </select>

              <InputError class="mt-2" :message="form.errors.goal_id" />
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
