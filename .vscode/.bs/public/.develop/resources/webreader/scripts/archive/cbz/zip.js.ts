// import * as zipJs from '@zip.js/zip.js'
// import { allowedExtensions, setImagesList } from './index'

// interface ZipFile {
//   name: string
//   file: zipJs.Entry
// }

// /**
//  * From `@zip.js/zip.js`
//  * https://github.com/gildas-lormeau/zip.js
//  */
// const readZipFile = async (path: string): Promise<void> => {
//   const reader = new zipJs.ZipReader(new zipJs.HttpReader(path))
//   const entries = await reader.getEntries()
//   let data: Map<string, Blob> = new Map()

//   if (entries.length) {
//     const zipFileList: ZipFile[] = []
//     entries.forEach((entry, key) => {
//       if (!entry.directory) {
//         zipFileList.push({
//           name: entry.filename,
//           file: entry,
//         })
//       }
//     })

//     const map = new Map()
//     await Promise.all(
//       zipFileList.map(async (zipFile) => {
//         const ext = zipFile.name.split('.')
//         const extension = ext[ext.length - 1]
//         if (allowedExtensions.includes(extension) && zipFile.file) {
//           // @ts-ignore
//           const blob = await zipFile.file.getData(new zipJs.BlobWriter())
//           map.set(zipFile.name, URL.createObjectURL(blob))
//         }
//       })
//     )

//     data = new Map([...map.entries()].sort())
//     setImagesList(data)
//   }

//   await reader.close()
// }

// export default readZipFile
