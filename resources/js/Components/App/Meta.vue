<script lang="ts" setup>
// https://inertiajs.com/title-and-meta#head-component
import { Head, usePage } from '@inertiajs/vue3'

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
  image: `/default.jpg`,
  type: 'website',
  twitter: 'summary_large_image',
})

const defaultTitle = 'Bookshelves'
const titleSeparator = '·'
const defaultDescription = 'For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you.'

const page = usePage()
const ziggy: any = page.props.ziggy
const baseURL = ziggy.url
const currentURL = ziggy.location

function getDomainFromUrl(url: string) {
  const urlObject = new URL(url)
  return urlObject.hostname
}

const currentTitle = props.title ? `${props.title} ${titleSeparator} ${defaultTitle}` : defaultTitle
const currentDescription = props.description || defaultDescription
const currentImage = props.image ? props.image : `${baseURL}${props.image}`
const currentType = props.type
const twitter = props.twitter
const currentUrl = currentURL
const currentDomain = getDomainFromUrl(currentURL)

console.log(baseURL)
console.log(currentURL)
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
