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
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Bookshelves',
  titleSeparator: '·',
  description: undefined,
  image: `/default.jpg`,
  type: 'website',
  twitter: 'summary_large_image',
  color: '#ffffff',
  author: undefined,
})

const defaultTitle = 'Bookshelves'
const defaultDescription = 'For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you.'

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
    return `${baseURL}/default.jpg`

  if (image.startsWith('http'))
    return image
  else
    return `${baseURL}${image}`
}

function limitText(text: string, limit: number) {
  return text.length > limit ? `${text.substring(0, limit)}...` : text
}

let currentTitle = props.title ? `${props.title} ${props.titleSeparator} ${defaultTitle}` : defaultTitle
currentTitle = limitText(currentTitle, 60)
let currentDescription = props.description || defaultDescription
currentDescription = limitText(currentDescription, 160)
const currentImage = checkImageURL(props.image)
const currentType = props.type
const twitter = props.twitter
const currentUrl = currentURL
const currentDomain = getDomainFromUrl(currentURL)
const currentColor = props.color
const currentAuthor = props.author || defaultTitle
</script>

<template>
  <Head :title="currentTitle">
    <meta
      head-key="og:type"
      property="og:type"
      :content="currentType"
    >
    <meta
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
      property="twitter:url"
      :content="currentUrl"
    >
    <meta
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
      name="twitter:image"
      :content="currentImage"
    >
    <!-- Metatag author -->
    <meta
      name="author"
      :content="currentAuthor"
    >
    <meta
      name="twitter:creator"
      :content="currentAuthor"
    >
    <!-- Metatag colors -->
    <meta
      name="msapplication-TileColor"
      :content="currentColor"
    >
    <meta
      name="theme-color"
      :content="currentColor"
    >
  </Head>
</template>
