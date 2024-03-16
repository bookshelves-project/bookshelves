<script lang="ts" setup>
// https://inertiajs.com/title-and-meta#head-component
import { Head, usePage } from '@inertiajs/vue3'

export interface Props {
  title?: string
  titleSeparator?: string
  description?: string
  image?: string
  type?: 'website' | 'article'
  twitter?: 'summary' | 'summary_large_image'
  color?: string
  author?: string
  defaultTitle?: string
  defaultDescription?: string
  defaultAuthor?: string
  defaultImage?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: undefined,
  titleSeparator: '·',
  description: undefined,
  image: `/default.jpg`,
  type: 'website',
  twitter: 'summary_large_image',
  color: '#ffffff',
  author: undefined,
  defaultTitle: undefined,
  defaultDescription: undefined,
  defaultAuthor: undefined,
  defaultImage: `/default.jpg`,
})

const page = usePage()
const ziggy: any = page.props.ziggy
const baseURL = ziggy.url
const currentURL = ziggy.location

function getDomainFromUrl(url: string) {
  const urlObject = new URL(url)
  return urlObject.hostname
}

function checkImageURL(image?: string) {
  if (!image)
    return `${baseURL}${props.defaultImage}`

  if (image.startsWith('http'))
    return image
  else
    return `${baseURL}${image}`
}

function limitText(text: string, limit: number) {
  return text.length > limit ? `${text.substring(0, limit)}...` : text
}

let currentTitle = props.title ? `${props.title} ${props.titleSeparator} ${props.defaultTitle}` : props.defaultTitle
currentTitle = limitText(currentTitle, 60)
let currentDescription = props.description || props.defaultDescription
currentDescription = limitText(currentDescription, 160)
const currentImage = checkImageURL(props.image)
const currentType = props.type
const twitter = props.twitter
const currentUrl = currentURL
const currentDomain = getDomainFromUrl(currentURL)
const currentColor = props.color
const currentAuthor = props.author || props.defaultTitle
</script>

<template>
  <Head :title="currentTitle">
    <meta
      head-key="og:type"
      property="og:type"
      :content="currentType"
    >
    <meta
      head-key="twitter:card"
      name="twitter:card"
      :content="twitter"
    >
    <!-- Metatag title -->
    <meta
      head-key="og:title"
      property="og:title"
      :content="currentTitle"
    >
    <meta
      head-key="twitter:title"
      name="twitter:title"
      :content="currentTitle"
    >
    <!-- Metatag URL -->
    <meta
      head-key="og:url"
      property="og:url"
      :content="currentUrl"
    >
    <meta
      head-key="twitter:url"
      property="twitter:url"
      :content="currentUrl"
    >
    <meta
      head-key="twitter:domain"
      property="twitter:domain"
      :content="currentDomain"
    >
    <!-- Metatag description -->
    <meta
      head-key="description"
      name="description"
      :content="currentDescription"
    >
    <meta
      head-key="og:description"
      property="og:description"
      :content="currentDescription"
    >
    <meta
      head-key="twitter:description"
      name="twitter:description"
      :content="currentDescription"
    >
    <!-- Metatag image -->
    <meta
      head-key="og:image"
      property="og:image"
      :content="currentImage"
    >
    <meta
      head-key="twitter:image"
      name="twitter:image"
      :content="currentImage"
    >
    <!-- Metatag author -->
    <meta
      head-key="author"
      name="author"
      :content="currentAuthor"
    >
    <meta
      head-key="twitter:creator"
      name="twitter:creator"
      :content="currentAuthor"
    >
    <!-- Metatag colors -->
    <meta
      head-key="msapplication-TileColor"
      name="msapplication-TileColor"
      :content="currentColor"
    >
    <meta
      head-key="theme-color"
      name="theme-color"
      :content="currentColor"
    >
  </Head>
</template>
