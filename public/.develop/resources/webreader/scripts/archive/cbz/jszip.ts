// import JSZip, { JSZipObject } from 'jszip'
// import JSZipUtils from 'jszip-utils'
// import { allowedExtensions, setImagesList } from './index'

// interface ZipFile {
//   name: string
//   file: JSZipObject
// }

// /**
//  * With `jszip` and `jszip-utils`
//  * https://stuk.github.io/jszip
//  */
// const readZipFile = async (path: string): Promise<void> => {
//   await JSZipUtils.getBinaryContent(path, async function (err, data) {
//     const entries = await JSZip.loadAsync(data)
//     const files = await extractFiles(entries)
//     setImagesList(files)
//   })
// }

// const extractFiles = async (entries: JSZip): Promise<Map<string, Blob>> => {
//   const zipFileList: ZipFile[] = []
//   entries.forEach((name, file) => {
//     zipFileList.push({
//       name: name,
//       file: file,
//     })
//   })

//   const map = new Map()
//   await Promise.all(
//     zipFileList.map(async (zipFile) => {
//       const ext = zipFile.name.split('.')
//       const extension = ext[ext.length - 1]
//       if (allowedExtensions.includes(extension)) {
//         const blob = new Blob([await zipFile.file.async('blob')])
//         const url = URL.createObjectURL(blob)
//         map.set(zipFile.name, url)
//       }
//     })
//   )

//   const zipMap = new Map([...map.entries()].sort())

//   return zipMap
// }

// export default readZipFile
