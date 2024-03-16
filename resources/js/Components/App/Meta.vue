<script lang="ts" setup>
import { Head } from '@inertiajs/vue3'

export interface Props {
  title?: string
  description?: string
  image?: string
  type?: 'website' | 'article'
  twitter?: 'summary' | 'summary_large_image'
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Bookshelves',
  description: undefined,
  image: `${window.location.origin}/default.jpg`,
  type: 'website',
  twitter: 'summary_large_image',
})

const currentTitle = props.title
const currentDescription = props.description
const currentImage = props.image
const currentType = props.type
const twitter = props.twitter
const currentUrl = '/'
const currentDomain = '/'
</script>

<template>
  <Head :title="currentTitle">
    <meta
      head-key="description"
      name="description"
      :content="currentDescription"
    >

    <meta
      head-key="og:url"
      property="og:url"
      :content="currentUrl"
    >
    <meta
      head-key="og:type"
      property="og:type"
      :content="currentType"
    >
    <meta
      head-key="og:title"
      property="og:title"
      :content="currentTitle"
    >
    <meta
      head-key="og:description"
      property="og:description"
      :content="currentDescription"
    >
    <meta
      head-key="og:image"
      property="og:image"
      :content="currentImage"
    >

    <meta
      name="twitter:card"
      :content="twitter"
    >
    <meta
      property="twitter:domain"
      :content="currentDomain"
    >
    <meta
      property="twitter:url"
      :content="currentUrl"
    >
    <meta
      name="twitter:title"
      :content="currentTitle"
    >
    <meta
      name="twitter:description"
      :content="currentDescription"
    >
    <meta
      name="twitter:image"
      :content="currentImage"
    >
  </Head>
</template>
