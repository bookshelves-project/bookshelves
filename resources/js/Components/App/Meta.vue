<script lang="ts" setup>
import { Head } from '@inertiajs/vue3'

export interface Props {
  title?: string
  description?: string
  image?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Bookshelves',
  description: 'For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you.',
  image: `${window.location.origin}/images/default.jpg`,
})

const currentUrl = computed(() => window.location.href)
const domain = computed(() => window.location.host)

const titleContent = computed(() => {
  if (!props.title)
    return 'Bookshelves'

  if (props.title.length > 60)
    return `${props.title.substring(0, 60)}...`

  return props.title
})
const descriptionContent = computed(() => {
  if (!props.description)
    return 'For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you.'

  if (props.description.length > 160)
    return `${props.description.substring(0, 160)}...`

  return props.description
})
</script>

<template>
  <Head :title="props.title">
    <!-- HTML Meta Tags -->
    <meta
      name="description"
      :content="descriptionContent"
    >

    <!-- Facebook Meta Tags -->
    <meta
      property="og:url"
      :content="currentUrl"
    >
    <meta
      property="og:type"
      content="website"
    >
    <meta
      property="og:title"
      :content="titleContent"
    >
    <meta
      property="og:description"
      :content="descriptionContent"
    >
    <meta
      property="og:image"
      :content="image"
    >

    <!-- Twitter Meta Tags -->
    <meta
      name="twitter:card"
      content="summary_large_image"
    >
    <meta
      property="twitter:domain"
      :content="domain"
    >
    <meta
      property="twitter:url"
      :content="currentUrl"
    >
    <meta
      name="twitter:title"
      :content="titleContent"
    >
    <meta
      name="twitter:description"
      :content="descriptionContent"
    >
    <meta
      name="twitter:image"
      :content="image"
    >

    <!-- Meta Tags Generated via https://www.opengraph.xyz -->
  </Head>
</template>
