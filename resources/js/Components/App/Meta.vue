<script lang="ts" setup>
// https://inertiajs.com/title-and-meta#head-component
import { Head, usePage } from '@inertiajs/vue3'
import { useMeta } from '@/Composables/useMeta'

export interface Props {
  title?: string
  titleSeparator?: string
  description?: string
  image?: string
  type?: 'website' | 'article'
  twitter?: 'summary' | 'summary_large_image'
  color?: string
  author?: string
  appTitle?: string
  appDescription?: string
  appAuthor?: string
  appImage?: string
  appColor?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: undefined,
  titleSeparator: '·',
  description: undefined,
  image: undefined,
  type: 'website',
  twitter: 'summary_large_image',
  color: undefined,
  author: undefined,
  appTitle: undefined,
  appDescription: undefined,
  appAuthor: undefined,
  appImage: `/default.jpg`,
  appColor: '#ffffff',
})

const { limit, removeTags, imageUrl, domainFromUrl, currentUrl } = useMeta()

let currentTitle = props.title
if (props.title && props.appTitle)
  currentTitle = `${props.title}`
if (!props.title)
  currentTitle = props.appTitle
currentTitle = limit(currentTitle, 50)

let currentDescription = props.description || props.appDescription
currentDescription = removeTags(currentDescription)
currentDescription = limit(currentDescription, 150)

const currentImage = imageUrl(props.image)
const currentType = props.type
const twitter = props.twitter

const currentDomain = domainFromUrl(currentUrl)
const currentColor = props.color || props.appColor
const currentAuthor = props.author || props.appTitle
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
