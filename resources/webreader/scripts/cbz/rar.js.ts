// import Rar from './rar/rar.js'
import RarArchive from 'rarjs'
import Reader from 'rarjs/lib/reader.js'
import { allowedExtensions, setImagesList } from './index'

interface RarFile {
  name: string
  file: object
}

/**
 * From `@zip.js/zip.js`
 * https://github.com/gildas-lormeau/zip.js
 */
const readRarFile = async (path: string): Promise<void> => {
  console.log(RarArchive.prototype)
  console.log(Reader.prototype)

  const archive = await RarArchive(path, async function (err) {
    let data: Map<string, Blob> = new Map()
    const map = new Map()

    const rarFileList: RarFile[] = []
    archive.entries.forEach((entry, key) => {
      if (!entry.directory) {
        rarFileList.push({
          name: entry.name,
          file: entry,
        })
      }
    })

    await Promise.all(
      rarFileList.map(async (rarFile) => {
        const ext = rarFile.name.split('.')
        const extension = ext[ext.length - 1]
        if (allowedExtensions.includes(extension)) {
          RarArchive.prototype.get(rarFile, function (file) {
            console.log(file)
          })
          // @ts-ignore
          const blob = new Blob([rarFile.file])
          map.set(rarFile.name, URL.createObjectURL(blob))
        }
      })
    )

    data = new Map([...map.entries()].sort())
    setImagesList(data)
  })
}

export default readRarFile
