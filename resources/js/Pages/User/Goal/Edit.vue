<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import InputError from "@/Components/InputError.vue"
import InputLabel from "@/Components/InputLabel.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"
import TextInput from "@/Components/TextInput.vue"
import { Head, Link, useForm } from "@inertiajs/vue3"

const props = defineProps({
  goal: Object
})

const form = useForm(props.goal)
</script>

<template>
  <Head title="Edit Goal" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Goal</h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <form @submit.prevent="form.put(route('user.goals.update', goal.id))" class="space-y-6 max-w-xl">
            <div>
              <InputLabel for="name" value="Name" />

              <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
              />

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
                <InputLabel for="start_date" value="Start Date" />

                <TextInput id="start_date" type="date" class="mt-1 block w-full" v-model="form.start_date" />

                <InputError class="mt-2" :message="form.errors.start_date" />
              </div>
              <div>
                <InputLabel for="due_date" value="Due Date" />

                <TextInput id="due_date" type="date" class="mt-1 block w-full" v-model="form.due_date" />

                <InputError class="mt-2" :message="form.errors.due_date" />
              </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
              <p class="text-sm mt-2 text-gray-800">
                Your email address is unverified.
                <Link
                  :href="route('verification.send')"
                  method="post"
                  as="button"
                  class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Click here to re-send the verification email.
                </Link>
              </p>

              <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
                A new verification link has been sent to your email address.
              </div>
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
