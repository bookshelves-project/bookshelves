'use strict'; const ki = Object.defineProperty; const Pc = Object.getOwnPropertyDescriptor; const Rc = Object.getOwnPropertyNames; const Lc = Object.prototype.hasOwnProperty; const zc = (n, e) => { for (const t in e)ki(n, t, { get: e[t], enumerable: !0 }) }; const Vc = (n, e, t, r) => {
  if (e && typeof e == 'object' || typeof e == 'function')
    for (const i of Rc(e))!Lc.call(n, i) && i !== t && ki(n, i, { get: () => e[i], enumerable: !(r = Pc(e, i)) || r.enumerable }); return n
}; const Hc = n => Vc(ki({}, '__esModule', { value: !0 }), n); const Ng = {}; zc(Ng, { CharacterCount: () => Mo, Editor: () => Un, Link: () => zo, StarterKit: () => Eo, Typography: () => Ao }); module.exports = Hc(Ng); function ne(n) { this.content = n }ne.prototype = {
  constructor: ne,
  find(n) {
    for (let e = 0; e < this.content.length; e += 2) {
      if (this.content[e] === n)
        return e
    } return -1
  },
  get(n) { const e = this.find(n); return e == -1 ? void 0 : this.content[e + 1] },
  update(n, e, t) { const r = t && t != n ? this.remove(t) : this; const i = r.find(n); const s = r.content.slice(); return i == -1 ? s.push(t || n, e) : (s[i + 1] = e, t && (s[i] = t)), new ne(s) },
  remove(n) {
    const e = this.find(n); if (e == -1)
      return this; const t = this.content.slice(); return t.splice(e, 2), new ne(t)
  },
  addToStart(n, e) { return new ne([n, e].concat(this.remove(n).content)) },
  addToEnd(n, e) { const t = this.remove(n).content.slice(); return t.push(n, e), new ne(t) },
  addBefore(n, e, t) { const r = this.remove(e); const i = r.content.slice(); const s = r.find(n); return i.splice(s == -1 ? i.length : s, 0, e, t), new ne(i) },
  forEach(n) { for (let e = 0; e < this.content.length; e += 2)n(this.content[e], this.content[e + 1]) },
  prepend(n) { return n = ne.from(n), n.size ? new ne(n.content.concat(this.subtract(n).content)) : this },
  append(n) { return n = ne.from(n), n.size ? new ne(this.subtract(n).content.concat(n.content)) : this },
  subtract(n) { let e = this; n = ne.from(n); for (let t = 0; t < n.content.length; t += 2)e = e.remove(n.content[t]); return e },
  get size() { return this.content.length >> 1 },
}; ne.from = function (n) {
  if (n instanceof ne)
    return n; const e = []; if (n)
    for (const t in n)e.push(t, n[t]); return new ne(e)
}; const Si = ne; function Jo(n, e, t) {
  for (let r = 0; ;r++) {
    if (r == n.childCount || r == e.childCount)
      return n.childCount == e.childCount ? null : t; const i = n.child(r); const s = e.child(r); if (i == s) { t += i.nodeSize; continue } if (!i.sameMarkup(s))
      return t; if (i.isText && i.text != s.text) { for (let o = 0; i.text[o] == s.text[o]; o++)t++; return t } if (i.content.size || s.content.size) {
      const o = Jo(i.content, s.content, t + 1); if (o != null)
        return o
    }t += i.nodeSize
  }
} function Uo(n, e, t, r) {
  for (let i = n.childCount, s = e.childCount; ;) {
    if (i == 0 || s == 0)
      return i == s ? null : { a: t, b: r }; const o = n.child(--i); const l = e.child(--s); const a = o.nodeSize; if (o == l) { t -= a, r -= a; continue } if (!o.sameMarkup(l))
      return { a: t, b: r }; if (o.isText && o.text != l.text) { let u = 0; const c = Math.min(o.text.length, l.text.length); for (;u < c && o.text[o.text.length - u - 1] == l.text[l.text.length - u - 1];)u++, t--, r--; return { a: t, b: r } } if (o.content.size || l.content.size) {
      const u = Uo(o.content, l.content, t - 1, r - 1); if (u)
        return u
    }t -= a, r -= a
  }
} var y = class {
  constructor(e, t) {
    if (this.content = e, this.size = t || 0, t == null)
      for (let r = 0; r < e.length; r++) this.size += e[r].nodeSize
  }

  nodesBetween(e, t, r, i = 0, s) { for (let o = 0, l = 0; l < t; o++) { const a = this.content[o]; const u = l + a.nodeSize; if (u > e && r(a, i + l, s || null, o) !== !1 && a.content.size) { const c = l + 1; a.nodesBetween(Math.max(0, e - c), Math.min(a.content.size, t - c), r, i + c) }l = u } }descendants(e) { this.nodesBetween(0, this.size, e) }textBetween(e, t, r, i) { let s = ''; let o = !0; return this.nodesBetween(e, t, (l, a) => { l.isText ? (s += l.text.slice(Math.max(e, a) - a, t - a), o = !r) : l.isLeaf ? (i ? s += typeof i == 'function' ? i(l) : i : l.type.spec.leafText && (s += l.type.spec.leafText(l)), o = !r) : !o && l.isBlock && (s += r, o = !0) }, 0), s }append(e) {
    if (!e.size)
      return this; if (!this.size)
      return e; const t = this.lastChild; const r = e.firstChild; const i = this.content.slice(); let s = 0; for (t.isText && t.sameMarkup(r) && (i[i.length - 1] = t.withText(t.text + r.text), s = 1); s < e.content.length; s++)i.push(e.content[s]); return new y(i, this.size + e.size)
  }

  cut(e, t = this.size) {
    if (e == 0 && t == this.size)
      return this; const r = []; let i = 0; if (t > e)
      for (let s = 0, o = 0; o < t; s++) { let l = this.content[s]; const a = o + l.nodeSize; a > e && ((o < e || a > t) && (l.isText ? l = l.cut(Math.max(0, e - o), Math.min(l.text.length, t - o)) : l = l.cut(Math.max(0, e - o - 1), Math.min(l.content.size, t - o - 1))), r.push(l), i += l.nodeSize), o = a } return new y(r, i)
  }

  cutByIndex(e, t) { return e == t ? y.empty : e == 0 && t == this.content.length ? this : new y(this.content.slice(e, t)) }replaceChild(e, t) {
    const r = this.content[e]; if (r == t)
      return this; const i = this.content.slice(); const s = this.size + t.nodeSize - r.nodeSize; return i[e] = t, new y(i, s)
  }

  addToStart(e) { return new y([e].concat(this.content), this.size + e.nodeSize) }addToEnd(e) { return new y(this.content.concat(e), this.size + e.nodeSize) }eq(e) {
    if (this.content.length != e.content.length)
      return !1; for (let t = 0; t < this.content.length; t++) {
      if (!this.content[t].eq(e.content[t]))
        return !1
    } return !0
  }

  get firstChild() { return this.content.length ? this.content[0] : null } get lastChild() { return this.content.length ? this.content[this.content.length - 1] : null } get childCount() { return this.content.length }child(e) {
    const t = this.content[e]; if (!t)
      throw new RangeError(`Index ${e} out of range for ${this}`); return t
  }

  maybeChild(e) { return this.content[e] || null }forEach(e) { for (let t = 0, r = 0; t < this.content.length; t++) { const i = this.content[t]; e(i, r, t), r += i.nodeSize } }findDiffStart(e, t = 0) { return Jo(this, e, t) }findDiffEnd(e, t = this.size, r = e.size) { return Uo(this, e, t, r) }findIndex(e, t = -1) {
    if (e == 0)
      return mr(0, e); if (e == this.size)
      return mr(this.content.length, e); if (e > this.size || e < 0)
      throw new RangeError(`Position ${e} outside of fragment (${this})`); for (let r = 0, i = 0; ;r++) {
      const s = this.child(r); const o = i + s.nodeSize; if (o >= e)
        return o == e || t > 0 ? mr(r + 1, o) : mr(r, i); i = o
    }
  }

  toString() { return `<${this.toStringInner()}>` }toStringInner() { return this.content.join(', ') }toJSON() { return this.content.length ? this.content.map(e => e.toJSON()) : null } static fromJSON(e, t) {
    if (!t)
      return y.empty; if (!Array.isArray(t))
      throw new RangeError('Invalid input for Fragment.fromJSON'); return new y(t.map(e.nodeFromJSON))
  }

  static fromArray(e) {
    if (!e.length)
      return y.empty; let t; let r = 0; for (let i = 0; i < e.length; i++) { const s = e[i]; r += s.nodeSize, i && s.isText && e[i - 1].sameMarkup(s) ? (t || (t = e.slice(0, i)), t[t.length - 1] = s.withText(t[t.length - 1].text + s.text)) : t && t.push(s) } return new y(t || e, r)
  }

  static from(e) {
    if (!e)
      return y.empty; if (e instanceof y)
      return e; if (Array.isArray(e))
      return this.fromArray(e); if (e.attrs)
      return new y([e], e.nodeSize); throw new RangeError(`Can not convert ${e} to a Fragment${e.nodesBetween ? ' (looks like multiple versions of prosemirror-model were loaded)' : ''}`)
  }
}; y.empty = new y([], 0); const xi = { index: 0, offset: 0 }; function mr(n, e) { return xi.index = n, xi.offset = e, xi } function gr(n, e) {
  if (n === e)
    return !0; if (!(n && typeof n == 'object') || !(e && typeof e == 'object'))
    return !1; const t = Array.isArray(n); if (Array.isArray(e) != t)
    return !1; if (t) {
    if (n.length != e.length)
      return !1; for (let r = 0; r < n.length; r++) {
      if (!gr(n[r], e[r]))
        return !1
    }
  }
  else {
    for (const r in n) {
      if (!(r in e) || !gr(n[r], e[r]))
        return !1
    } for (const r in e) {
      if (!(r in n))
        return !1
    }
  } return !0
} var w = class {
  constructor(e, t) { this.type = e, this.attrs = t }addToSet(e) {
    let t; let r = !1; for (let i = 0; i < e.length; i++) {
      const s = e[i]; if (this.eq(s))
        return e; if (this.type.excludes(s.type)) { t || (t = e.slice(0, i)) }
      else {
        if (s.type.excludes(this.type))
          return e; !r && s.type.rank > this.type.rank && (t || (t = e.slice(0, i)), t.push(this), r = !0), t && t.push(s)
      }
    } return t || (t = e.slice()), r || t.push(this), t
  }

  removeFromSet(e) {
    for (let t = 0; t < e.length; t++) {
      if (this.eq(e[t]))
        return e.slice(0, t).concat(e.slice(t + 1))
    } return e
  }

  isInSet(e) {
    for (let t = 0; t < e.length; t++) {
      if (this.eq(e[t]))
        return !0
    } return !1
  }

  eq(e) { return this == e || this.type == e.type && gr(this.attrs, e.attrs) }toJSON() { const e = { type: this.type.name }; for (const t in this.attrs) { e.attrs = this.attrs; break } return e } static fromJSON(e, t) {
    if (!t)
      throw new RangeError('Invalid input for Mark.fromJSON'); const r = e.marks[t.type]; if (!r)
      throw new RangeError(`There is no mark type ${t.type} in this schema`); return r.create(t.attrs)
  }

  static sameSet(e, t) {
    if (e == t)
      return !0; if (e.length != t.length)
      return !1; for (let r = 0; r < e.length; r++) {
      if (!e[r].eq(t[r]))
        return !1
    } return !0
  }

  static setFrom(e) {
    if (!e || Array.isArray(e) && e.length == 0)
      return w.none; if (e instanceof w)
      return [e]; const t = e.slice(); return t.sort((r, i) => r.type.rank - i.type.rank), t
  }
}; w.none = []; const Re = class extends Error {}; var b = class {
  constructor(e, t, r) { this.content = e, this.openStart = t, this.openEnd = r } get size() { return this.content.size - this.openStart - this.openEnd }insertAt(e, t) { const r = Yo(this.content, e + this.openStart, t); return r && new b(r, this.openStart, this.openEnd) }removeBetween(e, t) { return new b(Go(this.content, e + this.openStart, t + this.openStart), this.openStart, this.openEnd) }eq(e) { return this.content.eq(e.content) && this.openStart == e.openStart && this.openEnd == e.openEnd }toString() { return `${this.content}(${this.openStart},${this.openEnd})` }toJSON() {
    if (!this.content.size)
      return null; const e = { content: this.content.toJSON() }; return this.openStart > 0 && (e.openStart = this.openStart), this.openEnd > 0 && (e.openEnd = this.openEnd), e
  }

  static fromJSON(e, t) {
    if (!t)
      return b.empty; const r = t.openStart || 0; const i = t.openEnd || 0; if (typeof r != 'number' || typeof i != 'number')
      throw new RangeError('Invalid input for Slice.fromJSON'); return new b(y.fromJSON(e, t.content), r, i)
  }

  static maxOpen(e, t = !0) { let r = 0; let i = 0; for (let s = e.firstChild; s && !s.isLeaf && (t || !s.type.spec.isolating); s = s.firstChild)r++; for (let s = e.lastChild; s && !s.isLeaf && (t || !s.type.spec.isolating); s = s.lastChild)i++; return new b(e, r, i) }
}; b.empty = new b(y.empty, 0, 0); function Go(n, e, t) {
  const { index: r, offset: i } = n.findIndex(e); const s = n.maybeChild(r); const { index: o, offset: l } = n.findIndex(t); if (i == e || s.isText) {
    if (l != t && !n.child(o).isText)
      throw new RangeError('Removing non-flat range'); return n.cut(0, e).append(n.cut(t))
  } if (r != o)
    throw new RangeError('Removing non-flat range'); return n.replaceChild(r, s.copy(Go(s.content, e - i - 1, t - i - 1)))
} function Yo(n, e, t, r) {
  const { index: i, offset: s } = n.findIndex(e); const o = n.maybeChild(i); if (s == e || o.isText)
    return r && !r.canReplace(i, i, t) ? null : n.cut(0, e).append(t).append(n.cut(e)); const l = Yo(o.content, e - s - 1, t); return l && n.replaceChild(i, o.copy(l))
} function $c(n, e, t) {
  if (t.openStart > n.depth)
    throw new Re('Inserted content deeper than insertion position'); if (n.depth - t.openStart != e.depth - t.openEnd)
    throw new Re('Inconsistent open depths'); return Qo(n, e, t, 0)
} function Qo(n, e, t, r) {
  const i = n.index(r); const s = n.node(r); if (i == e.index(r) && r < n.depth - t.openStart) { const o = Qo(n, e, t, r + 1); return s.copy(s.content.replaceChild(i, o)) }
  else if (t.content.size) {
    if (!t.openStart && !t.openEnd && n.depth == r && e.depth == r) { const o = n.parent; const l = o.content; return Ft(o, l.cut(0, n.parentOffset).append(t.content).append(l.cut(e.parentOffset))) }
    else { const { start: o, end: l } = Kc(t, n); return Ft(s, Zo(n, o, l, e, r)) }
  }
  else { return Ft(s, yr(n, e, r)) }
} function Xo(n, e) {
  if (!e.type.compatibleContent(n.type))
    throw new Re(`Cannot join ${e.type.name} onto ${n.type.name}`)
} function Oi(n, e, t) { const r = n.node(t); return Xo(r, e.node(t)), r } function wt(n, e) { const t = e.length - 1; t >= 0 && n.isText && n.sameMarkup(e[t]) ? e[t] = n.withText(e[t].text + n.text) : e.push(n) } function Bn(n, e, t, r) { const i = (e || n).node(t); let s = 0; const o = e ? e.index(t) : i.childCount; n && (s = n.index(t), n.depth > t ? s++ : n.textOffset && (wt(n.nodeAfter, r), s++)); for (let l = s; l < o; l++)wt(i.child(l), r); e && e.depth == t && e.textOffset && wt(e.nodeBefore, r) } function Ft(n, e) {
  if (!n.type.validContent(e))
    throw new Re(`Invalid content for node ${n.type.name}`); return n.copy(e)
} function Zo(n, e, t, r, i) { const s = n.depth > i && Oi(n, e, i + 1); const o = r.depth > i && Oi(t, r, i + 1); const l = []; return Bn(null, n, i, l), s && o && e.index(i) == t.index(i) ? (Xo(s, o), wt(Ft(s, Zo(n, e, t, r, i + 1)), l)) : (s && wt(Ft(s, yr(n, e, i + 1)), l), Bn(e, t, i, l), o && wt(Ft(o, yr(t, r, i + 1)), l)), Bn(r, null, i, l), new y(l) } function yr(n, e, t) { const r = []; if (Bn(null, n, t, r), n.depth > t) { const i = Oi(n, e, t + 1); wt(Ft(i, yr(n, e, t + 1)), r) } return Bn(e, null, t, r), new y(r) } function Kc(n, e) { const t = e.depth - n.openStart; let i = e.node(t).copy(n.content); for (let s = t - 1; s >= 0; s--)i = e.node(s).copy(y.from(i)); return { start: i.resolveNoCache(n.openStart + t), end: i.resolveNoCache(i.content.size - n.openEnd - t) } } var vt = class {
  constructor(e, t, r) { this.pos = e, this.path = t, this.parentOffset = r, this.depth = t.length / 3 - 1 }resolveDepth(e) { return e == null ? this.depth : e < 0 ? this.depth + e : e } get parent() { return this.node(this.depth) } get doc() { return this.node(0) }node(e) { return this.path[this.resolveDepth(e) * 3] }index(e) { return this.path[this.resolveDepth(e) * 3 + 1] }indexAfter(e) { return e = this.resolveDepth(e), this.index(e) + (e == this.depth && !this.textOffset ? 0 : 1) }start(e) { return e = this.resolveDepth(e), e == 0 ? 0 : this.path[e * 3 - 1] + 1 }end(e) { return e = this.resolveDepth(e), this.start(e) + this.node(e).content.size }before(e) {
    if (e = this.resolveDepth(e), !e)
      throw new RangeError('There is no position before the top-level node'); return e == this.depth + 1 ? this.pos : this.path[e * 3 - 1]
  }

  after(e) {
    if (e = this.resolveDepth(e), !e)
      throw new RangeError('There is no position after the top-level node'); return e == this.depth + 1 ? this.pos : this.path[e * 3 - 1] + this.path[e * 3].nodeSize
  }

  get textOffset() { return this.pos - this.path[this.path.length - 1] } get nodeAfter() {
    const e = this.parent; const t = this.index(this.depth); if (t == e.childCount)
      return null; const r = this.pos - this.path[this.path.length - 1]; const i = e.child(t); return r ? e.child(t).cut(r) : i
  }

  get nodeBefore() { const e = this.index(this.depth); const t = this.pos - this.path[this.path.length - 1]; return t ? this.parent.child(e).cut(0, t) : e == 0 ? null : this.parent.child(e - 1) }posAtIndex(e, t) { t = this.resolveDepth(t); const r = this.path[t * 3]; let i = t == 0 ? 0 : this.path[t * 3 - 1] + 1; for (let s = 0; s < e; s++)i += r.child(s).nodeSize; return i }marks() {
    const e = this.parent; const t = this.index(); if (e.content.size == 0)
      return w.none; if (this.textOffset)
      return e.child(t).marks; let r = e.maybeChild(t - 1); let i = e.maybeChild(t); if (!r) { const l = r; r = i, i = l } let s = r.marks; for (let o = 0; o < s.length; o++)s[o].type.spec.inclusive === !1 && (!i || !s[o].isInSet(i.marks)) && (s = s[o--].removeFromSet(s)); return s
  }

  marksAcross(e) {
    const t = this.parent.maybeChild(this.index()); if (!t || !t.isInline)
      return null; let r = t.marks; const i = e.parent.maybeChild(e.index()); for (let s = 0; s < r.length; s++)r[s].type.spec.inclusive === !1 && (!i || !r[s].isInSet(i.marks)) && (r = r[s--].removeFromSet(r)); return r
  }

  sharedDepth(e) {
    for (let t = this.depth; t > 0; t--) {
      if (this.start(t) <= e && this.end(t) >= e)
        return t
    } return 0
  }

  blockRange(e = this, t) {
    if (e.pos < this.pos)
      return e.blockRange(this); for (let r = this.depth - (this.parent.inlineContent || this.pos == e.pos ? 1 : 0); r >= 0; r--) {
      if (e.pos <= this.end(r) && (!t || t(this.node(r))))
        return new Bt(this, e, r)
    } return null
  }

  sameParent(e) { return this.pos - this.parentOffset == e.pos - e.parentOffset }max(e) { return e.pos > this.pos ? e : this }min(e) { return e.pos < this.pos ? e : this }toString() { let e = ''; for (let t = 1; t <= this.depth; t++)e += `${(e ? '/' : '') + this.node(t).type.name}_${this.index(t - 1)}`; return `${e}:${this.parentOffset}` } static resolve(e, t) {
    if (!(t >= 0 && t <= e.content.size))
      throw new RangeError(`Position ${t} out of range`); const r = []; let i = 0; let s = t; for (let o = e; ;) {
      const { index: l, offset: a } = o.content.findIndex(s); const u = s - a; if (r.push(o, l, i + a), !u || (o = o.child(l), o.isText))
        break; s = u - 1, i += a + 1
    } return new vt(t, r, s)
  }

  static resolveCached(e, t) {
    for (let i = 0; i < Ei.length; i++) {
      const s = Ei[i]; if (s.pos == t && s.doc == e)
        return s
    } const r = Ei[Ai] = vt.resolve(e, t); return Ai = (Ai + 1) % jc, r
  }
}; var Ei = []; var Ai = 0; var jc = 12; var Bt = class {constructor(e, t, r) { this.$from = e, this.$to = t, this.depth = r } get start() { return this.$from.before(this.depth + 1) } get end() { return this.$to.after(this.depth + 1) } get parent() { return this.$from.node(this.depth) } get startIndex() { return this.$from.index(this.depth) } get endIndex() { return this.$to.indexAfter(this.depth) }}; const Wc = Object.create(null); var he = class {
  constructor(e, t, r, i = w.none) { this.type = e, this.attrs = t, this.marks = i, this.content = r || y.empty } get nodeSize() { return this.isLeaf ? 1 : 2 + this.content.size } get childCount() { return this.content.childCount }child(e) { return this.content.child(e) }maybeChild(e) { return this.content.maybeChild(e) }forEach(e) { this.content.forEach(e) }nodesBetween(e, t, r, i = 0) { this.content.nodesBetween(e, t, r, i, this) }descendants(e) { this.nodesBetween(0, this.content.size, e) } get textContent() { return this.isLeaf && this.type.spec.leafText ? this.type.spec.leafText(this) : this.textBetween(0, this.content.size, '') }textBetween(e, t, r, i) { return this.content.textBetween(e, t, r, i) } get firstChild() { return this.content.firstChild } get lastChild() { return this.content.lastChild }eq(e) { return this == e || this.sameMarkup(e) && this.content.eq(e.content) }sameMarkup(e) { return this.hasMarkup(e.type, e.attrs, e.marks) }hasMarkup(e, t, r) { return this.type == e && gr(this.attrs, t || e.defaultAttrs || Wc) && w.sameSet(this.marks, r || w.none) }copy(e = null) { return e == this.content ? this : new he(this.type, this.attrs, e, this.marks) }mark(e) { return e == this.marks ? this : new he(this.type, this.attrs, this.content, e) }cut(e, t = this.content.size) { return e == 0 && t == this.content.size ? this : this.copy(this.content.cut(e, t)) }slice(e, t = this.content.size, r = !1) {
    if (e == t)
      return b.empty; const i = this.resolve(e); const s = this.resolve(t); const o = r ? 0 : i.sharedDepth(t); const l = i.start(o); const u = i.node(o).content.cut(i.pos - l, s.pos - l); return new b(u, i.depth - o, s.depth - o)
  }

  replace(e, t, r) { return $c(this.resolve(e), this.resolve(t), r) }nodeAt(e) {
    for (let t = this; ;) {
      const { index: r, offset: i } = t.content.findIndex(e); if (t = t.maybeChild(r), !t)
        return null; if (i == e || t.isText)
        return t; e -= i + 1
    }
  }

  childAfter(e) { const { index: t, offset: r } = this.content.findIndex(e); return { node: this.content.maybeChild(t), index: t, offset: r } }childBefore(e) {
    if (e == 0)
      return { node: null, index: 0, offset: 0 }; const { index: t, offset: r } = this.content.findIndex(e); if (r < e)
      return { node: this.content.child(t), index: t, offset: r }; const i = this.content.child(t - 1); return { node: i, index: t - 1, offset: r - i.nodeSize }
  }

  resolve(e) { return vt.resolveCached(this, e) }resolveNoCache(e) { return vt.resolve(this, e) }rangeHasMark(e, t, r) { let i = !1; return t > e && this.nodesBetween(e, t, s => (r.isInSet(s.marks) && (i = !0), !i)), i } get isBlock() { return this.type.isBlock } get isTextblock() { return this.type.isTextblock } get inlineContent() { return this.type.inlineContent } get isInline() { return this.type.isInline } get isText() { return this.type.isText } get isLeaf() { return this.type.isLeaf } get isAtom() { return this.type.isAtom }toString() {
    if (this.type.spec.toDebugString)
      return this.type.spec.toDebugString(this); let e = this.type.name; return this.content.size && (e += `(${this.content.toStringInner()})`), el(this.marks, e)
  }

  contentMatchAt(e) {
    const t = this.type.contentMatch.matchFragment(this.content, 0, e); if (!t)
      throw new Error('Called contentMatchAt on a node with invalid content'); return t
  }

  canReplace(e, t, r = y.empty, i = 0, s = r.childCount) {
    const o = this.contentMatchAt(e).matchFragment(r, i, s); const l = o && o.matchFragment(this.content, t); if (!l || !l.validEnd)
      return !1; for (let a = i; a < s; a++) {
      if (!this.type.allowsMarks(r.child(a).marks))
        return !1
    } return !0
  }

  canReplaceWith(e, t, r, i) {
    if (i && !this.type.allowsMarks(i))
      return !1; const s = this.contentMatchAt(e).matchType(r); const o = s && s.matchFragment(this.content, t); return o ? o.validEnd : !1
  }

  canAppend(e) { return e.content.size ? this.canReplace(this.childCount, this.childCount, e.content) : this.type.compatibleContent(e.type) }check() {
    if (!this.type.validContent(this.content))
      throw new RangeError(`Invalid content for node ${this.type.name}: ${this.content.toString().slice(0, 50)}`); let e = w.none; for (let t = 0; t < this.marks.length; t++)e = this.marks[t].addToSet(e); if (!w.sameSet(e, this.marks))
      throw new RangeError(`Invalid collection of marks for node ${this.type.name}: ${this.marks.map(t => t.type.name)}`); this.content.forEach(t => t.check())
  }

  toJSON() { const e = { type: this.type.name }; for (const t in this.attrs) { e.attrs = this.attrs; break } return this.content.size && (e.content = this.content.toJSON()), this.marks.length && (e.marks = this.marks.map(t => t.toJSON())), e } static fromJSON(e, t) {
    if (!t)
      throw new RangeError('Invalid input for Node.fromJSON'); let r = null; if (t.marks) {
      if (!Array.isArray(t.marks))
        throw new RangeError('Invalid mark data for Node.fromJSON'); r = t.marks.map(e.markFromJSON)
    } if (t.type == 'text') {
      if (typeof t.text != 'string')
        throw new RangeError('Invalid text node in JSON'); return e.text(t.text, r)
    } const i = y.fromJSON(e, t.content); return e.nodeType(t.type).create(t.attrs, i, r)
  }
}; he.prototype.text = void 0; var rn = class extends he {
  constructor(e, t, r, i) {
    if (super(e, t, null, i), !r)
      throw new RangeError('Empty text nodes are not allowed'); this.text = r
  }

  toString() { return this.type.spec.toDebugString ? this.type.spec.toDebugString(this) : el(this.marks, JSON.stringify(this.text)) } get textContent() { return this.text }textBetween(e, t) { return this.text.slice(e, t) } get nodeSize() { return this.text.length }mark(e) { return e == this.marks ? this : new rn(this.type, this.attrs, this.text, e) }withText(e) { return e == this.text ? this : new rn(this.type, this.attrs, e, this.marks) }cut(e = 0, t = this.text.length) { return e == 0 && t == this.text.length ? this : this.withText(this.text.slice(e, t)) }eq(e) { return this.sameMarkup(e) && this.text == e.text }toJSON() { const e = super.toJSON(); return e.text = this.text, e }
}; function el(n, e) { for (let t = n.length - 1; t >= 0; t--)e = `${n[t].type.name}(${e})`; return e } var Ye = class {
  constructor(e) { this.validEnd = e, this.next = [], this.wrapCache = [] } static parse(e, t) {
    const r = new Ti(e, t); if (r.next == null)
      return Ye.empty; const i = tl(r); r.next && r.err('Unexpected trailing text'); const s = Qc(Yc(i)); return Xc(s, r), s
  }

  matchType(e) {
    for (let t = 0; t < this.next.length; t++) {
      if (this.next[t].type == e)
        return this.next[t].next
    } return null
  }

  matchFragment(e, t = 0, r = e.childCount) { let i = this; for (let s = t; i && s < r; s++)i = i.matchType(e.child(s).type); return i } get inlineContent() { return this.next.length && this.next[0].type.isInline } get defaultType() {
    for (let e = 0; e < this.next.length; e++) {
      const { type: t } = this.next[e]; if (!(t.isText || t.hasRequiredAttrs()))
        return t
    } return null
  }

  compatible(e) {
    for (let t = 0; t < this.next.length; t++) {
      for (let r = 0; r < e.next.length; r++) {
        if (this.next[t].type == e.next[r].type)
          return !0
      }
    } return !1
  }

  fillBefore(e, t = !1, r = 0) {
    const i = [this]; function s(o, l) {
      const a = o.matchFragment(e, r); if (a && (!t || a.validEnd))
        return y.from(l.map(u => u.createAndFill())); for (let u = 0; u < o.next.length; u++) {
        const { type: c, next: d } = o.next[u]; if (!(c.isText || c.hasRequiredAttrs()) && !i.includes(d)) {
          i.push(d); const f = s(d, l.concat(c)); if (f)
            return f
        }
      } return null
    } return s(this, [])
  }

  findWrapping(e) {
    for (let r = 0; r < this.wrapCache.length; r += 2) {
      if (this.wrapCache[r] == e)
        return this.wrapCache[r + 1]
    } const t = this.computeWrapping(e); return this.wrapCache.push(e, t), t
  }

  computeWrapping(e) { const t = Object.create(null); const r = [{ match: this, type: null, via: null }]; for (;r.length;) { const i = r.shift(); const s = i.match; if (s.matchType(e)) { const o = []; for (let l = i; l.type; l = l.via)o.push(l.type); return o.reverse() } for (let o = 0; o < s.next.length; o++) { const { type: l, next: a } = s.next[o]; !l.isLeaf && !l.hasRequiredAttrs() && !(l.name in t) && (!i.type || a.validEnd) && (r.push({ match: l.contentMatch, type: l, via: i }), t[l.name] = !0) } } return null } get edgeCount() { return this.next.length }edge(e) {
    if (e >= this.next.length)
      throw new RangeError(`There's no ${e}th edge in this content match`); return this.next[e]
  }

  toString() {
    const e = []; function t(r) { e.push(r); for (let i = 0; i < r.next.length; i++)!e.includes(r.next[i].next) && t(r.next[i].next) } return t(this), e.map((r, i) => { let s = `${i + (r.validEnd ? '*' : ' ')} `; for (let o = 0; o < r.next.length; o++)s += `${(o ? ', ' : '') + r.next[o].type.name}->${e.indexOf(r.next[o].next)}`; return s }).join(`
`)
  }
}; Ye.empty = new Ye(!0); var Ti = class {constructor(e, t) { this.string = e, this.nodeTypes = t, this.inline = null, this.pos = 0, this.tokens = e.split(/\s*(?=\b|\W|$)/), this.tokens[this.tokens.length - 1] == '' && this.tokens.pop(), this.tokens[0] == '' && this.tokens.shift() } get next() { return this.tokens[this.pos] }eat(e) { return this.next == e && (this.pos++ || !0) }err(e) { throw new SyntaxError(`${e} (in content expression '${this.string}')`) }}; function tl(n) { const e = []; do e.push(qc(n)); while (n.eat('|')); return e.length == 1 ? e[0] : { type: 'choice', exprs: e } } function qc(n) { const e = []; do e.push(_c(n)); while (n.next && n.next != ')' && n.next != '|'); return e.length == 1 ? e[0] : { type: 'seq', exprs: e } } function _c(n) {
  let e = Gc(n); for (;;) {
    if (n.eat('+'))
      e = { type: 'plus', expr: e }; else if (n.eat('*'))
      e = { type: 'star', expr: e }; else if (n.eat('?'))
      e = { type: 'opt', expr: e }; else if (n.eat('{'))
      e = Jc(n, e); else break
  } return e
} function $o(n) { /\D/.test(n.next) && n.err(`Expected number, got '${n.next}'`); const e = Number(n.next); return n.pos++, e } function Jc(n, e) { const t = $o(n); let r = t; return n.eat(',') && (n.next != '}' ? r = $o(n) : r = -1), n.eat('}') || n.err('Unclosed braced range'), { type: 'range', min: t, max: r, expr: e } } function Uc(n, e) {
  const t = n.nodeTypes; const r = t[e]; if (r)
    return [r]; const i = []; for (const s in t) { const o = t[s]; o.groups.includes(e) && i.push(o) } return i.length == 0 && n.err(`No node type or group '${e}' found`), i
} function Gc(n) {
  if (n.eat('(')) { const e = tl(n); return n.eat(')') || n.err('Missing closing paren'), e }
  else if (/\W/.test(n.next)) { n.err(`Unexpected token '${n.next}'`) }
  else { const e = Uc(n, n.next).map(t => (n.inline == null ? n.inline = t.isInline : n.inline != t.isInline && n.err('Mixing inline and block content'), { type: 'name', value: t })); return n.pos++, e.length == 1 ? e[0] : { type: 'choice', exprs: e } }
} function Yc(n) {
  const e = [[]]; return i(s(n, 0), t()), e; function t() { return e.push([]) - 1 } function r(o, l, a) { const u = { term: a, to: l }; return e[o].push(u), u } function i(o, l) { o.forEach(a => a.to = l) } function s(o, l) {
    if (o.type == 'choice')
      return o.exprs.reduce((a, u) => a.concat(s(u, l)), []); if (o.type == 'seq') {
      for (let a = 0; ;a++) {
        const u = s(o.exprs[a], l); if (a == o.exprs.length - 1)
          return u; i(u, l = t())
      }
    }
    else if (o.type == 'star') { const a = t(); return r(l, a), i(s(o.expr, a), a), [r(a)] }
    else if (o.type == 'plus') { const a = t(); return i(s(o.expr, l), a), i(s(o.expr, a), a), [r(a)] }
    else {
      if (o.type == 'opt')
        return [r(l)].concat(s(o.expr, l)); if (o.type == 'range') {
        let a = l; for (let u = 0; u < o.min; u++) { const c = t(); i(s(o.expr, a), c), a = c } if (o.max == -1)
          i(s(o.expr, a), a); else for (let u = o.min; u < o.max; u++) { const c = t(); r(a, c), i(s(o.expr, a), c), a = c } return [r(a)]
      }
      else {
        if (o.type == 'name')
          return [r(l, void 0, o.value)]; throw new Error('Unknown expr type')
      }
    }
  }
} function nl(n, e) { return e - n } function Ko(n, e) {
  const t = []; return r(e), t.sort(nl); function r(i) {
    const s = n[i]; if (s.length == 1 && !s[0].term)
      return r(s[0].to); t.push(i); for (let o = 0; o < s.length; o++) { const { term: l, to: a } = s[o]; !l && !t.includes(a) && r(a) }
  }
} function Qc(n) {
  const e = Object.create(null); return t(Ko(n, 0)); function t(r) {
    const i = []; r.forEach((o) => {
      n[o].forEach(({ term: l, to: a }) => {
        if (!l)
          return; let u; for (let c = 0; c < i.length; c++)i[c][0] == l && (u = i[c][1]); Ko(n, a).forEach((c) => { u || i.push([l, u = []]), !u.includes(c) && u.push(c) })
      })
    }); const s = e[r.join(',')] = new Ye(r.includes(n.length - 1)); for (let o = 0; o < i.length; o++) { const l = i[o][1].sort(nl); s.next.push({ type: i[o][0], next: e[l.join(',')] || t(l) }) } return s
  }
} function Xc(n, e) { for (let t = 0, r = [n]; t < r.length; t++) { const i = r[t]; let s = !i.validEnd; const o = []; for (let l = 0; l < i.next.length; l++) { const { type: a, next: u } = i.next[l]; o.push(a.name), s && !(a.isText || a.hasRequiredAttrs()) && (s = !1), !r.includes(u) && r.push(u) }s && e.err(`Only non-generatable nodes (${o.join(', ')}) in a required position (see https://prosemirror.net/docs/guide/#generatable)`) } } function rl(n) {
  const e = Object.create(null); for (const t in n) {
    const r = n[t]; if (!r.hasDefault)
      return null; e[t] = r.default
  } return e
} function il(n, e) {
  const t = Object.create(null); for (const r in n) {
    let i = e && e[r]; if (i === void 0) {
      const s = n[r]; if (s.hasDefault)
        i = s.default; else throw new RangeError(`No value supplied for attribute ${r}`)
    }t[r] = i
  } return t
} function sl(n) {
  const e = Object.create(null); if (n)
    for (const t in n)e[t] = new Ni(n[t]); return e
} var sn = class {
  constructor(e, t, r) { this.name = e, this.schema = t, this.spec = r, this.markSet = null, this.groups = r.group ? r.group.split(' ') : [], this.attrs = sl(r.attrs), this.defaultAttrs = rl(this.attrs), this.contentMatch = null, this.inlineContent = null, this.isBlock = !(r.inline || e == 'text'), this.isText = e == 'text' } get isInline() { return !this.isBlock } get isTextblock() { return this.isBlock && this.inlineContent } get isLeaf() { return this.contentMatch == Ye.empty } get isAtom() { return this.isLeaf || !!this.spec.atom } get whitespace() { return this.spec.whitespace || (this.spec.code ? 'pre' : 'normal') }hasRequiredAttrs() {
    for (const e in this.attrs) {
      if (this.attrs[e].isRequired)
        return !0
    } return !1
  }

  compatibleContent(e) { return this == e || this.contentMatch.compatible(e.contentMatch) }computeAttrs(e) { return !e && this.defaultAttrs ? this.defaultAttrs : il(this.attrs, e) }create(e = null, t, r) {
    if (this.isText)
      throw new Error('NodeType.create can\'t construct text nodes'); return new he(this, this.computeAttrs(e), y.from(t), w.setFrom(r))
  }

  createChecked(e = null, t, r) {
    if (t = y.from(t), !this.validContent(t))
      throw new RangeError(`Invalid content for node ${this.name}`); return new he(this, this.computeAttrs(e), t, w.setFrom(r))
  }

  createAndFill(e = null, t, r) {
    if (e = this.computeAttrs(e), t = y.from(t), t.size) {
      const o = this.contentMatch.fillBefore(t); if (!o)
        return null; t = o.append(t)
    } const i = this.contentMatch.matchFragment(t); const s = i && i.fillBefore(y.empty, !0); return s ? new he(this, e, t.append(s), w.setFrom(r)) : null
  }

  validContent(e) {
    const t = this.contentMatch.matchFragment(e); if (!t || !t.validEnd)
      return !1; for (let r = 0; r < e.childCount; r++) {
      if (!this.allowsMarks(e.child(r).marks))
        return !1
    } return !0
  }

  allowsMarkType(e) { return this.markSet == null || this.markSet.includes(e) }allowsMarks(e) {
    if (this.markSet == null)
      return !0; for (let t = 0; t < e.length; t++) {
      if (!this.allowsMarkType(e[t].type))
        return !1
    } return !0
  }

  allowedMarks(e) {
    if (this.markSet == null)
      return e; let t; for (let r = 0; r < e.length; r++) this.allowsMarkType(e[r].type) ? t && t.push(e[r]) : t || (t = e.slice(0, r)); return t ? t.length ? t : w.none : e
  }

  static compile(e, t) {
    const r = Object.create(null); e.forEach((s, o) => r[s] = new sn(s, t, o)); const i = t.spec.topNode || 'doc'; if (!r[i])
      throw new RangeError(`Schema is missing its top node type ('${i}')`); if (!r.text)
      throw new RangeError('Every schema needs a \'text\' type'); for (const s in r.text.attrs) throw new RangeError('The text node type should not have attributes'); return r
  }
}; var Ni = class {constructor(e) { this.hasDefault = Object.prototype.hasOwnProperty.call(e, 'default'), this.default = e.default } get isRequired() { return !this.hasDefault }}; var ft = class {
  constructor(e, t, r, i) { this.name = e, this.rank = t, this.schema = r, this.spec = i, this.attrs = sl(i.attrs), this.excluded = null; const s = rl(this.attrs); this.instance = s ? new w(this, s) : null }create(e = null) { return !e && this.instance ? this.instance : new w(this, il(this.attrs, e)) } static compile(e, t) { const r = Object.create(null); let i = 0; return e.forEach((s, o) => r[s] = new ft(s, i++, t, o)), r }removeFromSet(e) { for (let t = 0; t < e.length; t++)e[t].type == this && (e = e.slice(0, t).concat(e.slice(t + 1)), t--); return e }isInSet(e) {
    for (let t = 0; t < e.length; t++) {
      if (e[t].type == this)
        return e[t]
    }
  }

  excludes(e) { return this.excluded.includes(e) }
}; const Dr = class {
  constructor(e) {
    this.cached = Object.create(null), this.spec = { nodes: Si.from(e.nodes), marks: Si.from(e.marks || {}), topNode: e.topNode }, this.nodes = sn.compile(this.spec.nodes, this), this.marks = ft.compile(this.spec.marks, this); const t = Object.create(null); for (const r in this.nodes) {
      if (r in this.marks)
        throw new RangeError(`${r} can not be both a node and a mark`); const i = this.nodes[r]; const s = i.spec.content || ''; const o = i.spec.marks; i.contentMatch = t[s] || (t[s] = Ye.parse(s, this.nodes)), i.inlineContent = i.contentMatch.inlineContent, i.markSet = o == '_' ? null : o ? jo(this, o.split(' ')) : o == '' || !i.inlineContent ? [] : null
    } for (const r in this.marks) { const i = this.marks[r]; const s = i.spec.excludes; i.excluded = s == null ? [i] : s == '' ? [] : jo(this, s.split(' ')) } this.nodeFromJSON = this.nodeFromJSON.bind(this), this.markFromJSON = this.markFromJSON.bind(this), this.topNodeType = this.nodes[this.spec.topNode || 'doc'], this.cached.wrappings = Object.create(null)
  }

  node(e, t = null, r, i) {
    if (typeof e == 'string') { e = this.nodeType(e) }
    else if (e instanceof sn) {
      if (e.schema != this)
        throw new RangeError(`Node type from different schema used (${e.name})`)
    }
    else { throw new RangeError(`Invalid node type: ${e}`) } return e.createChecked(t, r, i)
  }

  text(e, t) { const r = this.nodes.text; return new rn(r, r.defaultAttrs, e, w.setFrom(t)) }mark(e, t) { return typeof e == 'string' && (e = this.marks[e]), e.create(t) }nodeFromJSON(e) { return he.fromJSON(this, e) }markFromJSON(e) { return w.fromJSON(this, e) }nodeType(e) {
    const t = this.nodes[e]; if (!t)
      throw new RangeError(`Unknown node type: ${e}`); return t
  }
}; function jo(n, e) {
  const t = []; for (let r = 0; r < e.length; r++) {
    const i = e[r]; const s = n.marks[i]; let o = s; if (s)
      t.push(s); else for (const l in n.marks) { const a = n.marks[l]; (i == '_' || a.spec.group && a.spec.group.split(' ').includes(i)) && t.push(o = a) } if (!o)
      throw new SyntaxError(`Unknown mark type: '${e[r]}'`)
  } return t
} var Ae = class {
  constructor(e, t) {
    this.schema = e, this.rules = t, this.tags = [], this.styles = [], t.forEach((r) => { r.tag ? this.tags.push(r) : r.style && this.styles.push(r) }), this.normalizeLists = !this.tags.some((r) => {
      if (!/^(ul|ol)\b/.test(r.tag) || !r.node)
        return !1; const i = e.nodes[r.node]; return i.contentMatch.matchType(i)
    })
  }

  parse(e, t = {}) { const r = new kr(this, t, !1); return r.addAll(e, t.from, t.to), r.finish() }parseSlice(e, t = {}) { const r = new kr(this, t, !0); return r.addAll(e, t.from, t.to), b.maxOpen(r.finish()) }matchTag(e, t, r) {
    for (let i = r ? this.tags.indexOf(r) + 1 : 0; i < this.tags.length; i++) {
      const s = this.tags[i]; if (td(e, s.tag) && (s.namespace === void 0 || e.namespaceURI == s.namespace) && (!s.context || t.matchesContext(s.context))) {
        if (s.getAttrs) {
          const o = s.getAttrs(e); if (o === !1)
            continue; s.attrs = o || void 0
        } return s
      }
    }
  }

  matchStyle(e, t, r, i) {
    for (let s = i ? this.styles.indexOf(i) + 1 : 0; s < this.styles.length; s++) {
      const o = this.styles[s]; const l = o.style; if (!(l.indexOf(e) != 0 || o.context && !r.matchesContext(o.context) || l.length > e.length && (l.charCodeAt(e.length) != 61 || l.slice(e.length + 1) != t))) {
        if (o.getAttrs) {
          const a = o.getAttrs(t); if (a === !1)
            continue; o.attrs = a || void 0
        } return o
      }
    }
  }

  static schemaRules(e) {
    const t = []; function r(i) {
      const s = i.priority == null ? 50 : i.priority; let o = 0; for (;o < t.length; o++) {
        const l = t[o]; if ((l.priority == null ? 50 : l.priority) < s)
          break
      }t.splice(o, 0, i)
    } for (const i in e.marks) { const s = e.marks[i].spec.parseDOM; s && s.forEach((o) => { r(o = qo(o)), o.mark = i }) } for (const i in e.nodes) { const s = e.nodes[i].spec.parseDOM; s && s.forEach((o) => { r(o = qo(o)), o.node = i }) } return t
  }

  static fromSchema(e) { return e.cached.domParser || (e.cached.domParser = new Ae(e, Ae.schemaRules(e))) }
}; const ol = { address: !0, article: !0, aside: !0, blockquote: !0, canvas: !0, dd: !0, div: !0, dl: !0, fieldset: !0, figcaption: !0, figure: !0, footer: !0, form: !0, h1: !0, h2: !0, h3: !0, h4: !0, h5: !0, h6: !0, header: !0, hgroup: !0, hr: !0, li: !0, noscript: !0, ol: !0, output: !0, p: !0, pre: !0, section: !0, table: !0, tfoot: !0, ul: !0 }; const Zc = { head: !0, noscript: !0, object: !0, script: !0, style: !0, title: !0 }; const ll = { ol: !0, ul: !0 }; const br = 1; const Cr = 2; const In = 4; function Wo(n, e, t) { return e != null ? (e ? br : 0) | (e === 'full' ? Cr : 0) : n && n.whitespace == 'pre' ? br | Cr : t & ~In } const nn = class {
  constructor(e, t, r, i, s, o, l) { this.type = e, this.attrs = t, this.marks = r, this.pendingMarks = i, this.solid = s, this.options = l, this.content = [], this.activeMarks = w.none, this.stashMarks = [], this.match = o || (l & In ? null : e.contentMatch) }findWrapping(e) {
    if (!this.match) {
      if (!this.type)
        return []; const t = this.type.contentMatch.fillBefore(y.from(e)); if (t) { this.match = this.type.contentMatch.matchFragment(t) }
      else { const r = this.type.contentMatch; let i; return (i = r.findWrapping(e.type)) ? (this.match = r, i) : null }
    } return this.match.findWrapping(e.type)
  }

  finish(e) { if (!(this.options & br)) { const r = this.content[this.content.length - 1]; let i; if (r && r.isText && (i = /[ \t\r\n\u000C]+$/.exec(r.text))) { const s = r; r.text.length == i[0].length ? this.content.pop() : this.content[this.content.length - 1] = s.withText(s.text.slice(0, s.text.length - i[0].length)) } } let t = y.from(this.content); return !e && this.match && (t = t.append(this.match.fillBefore(y.empty, !0))), this.type ? this.type.create(this.attrs, t, this.marks) : t }popFromStashMark(e) {
    for (let t = this.stashMarks.length - 1; t >= 0; t--) {
      if (e.eq(this.stashMarks[t]))
        return this.stashMarks.splice(t, 1)[0]
    }
  }

  applyPending(e) { for (let t = 0, r = this.pendingMarks; t < r.length; t++) { const i = r[t]; (this.type ? this.type.allowsMarkType(i.type) : rd(i.type, e)) && !i.isInSet(this.activeMarks) && (this.activeMarks = i.addToSet(this.activeMarks), this.pendingMarks = i.removeFromSet(this.pendingMarks)) } }inlineContext(e) { return this.type ? this.type.inlineContent : this.content.length ? this.content[0].isInline : e.parentNode && !ol.hasOwnProperty(e.parentNode.nodeName.toLowerCase()) }
}; var kr = class {
  constructor(e, t, r) { this.parser = e, this.options = t, this.isOpen = r, this.open = 0; const i = t.topNode; let s; const o = Wo(null, t.preserveWhitespace, 0) | (r ? In : 0); i ? s = new nn(i.type, i.attrs, w.none, w.none, !0, t.topMatch || i.type.contentMatch, o) : r ? s = new nn(null, null, w.none, w.none, !0, null, o) : s = new nn(e.schema.topNodeType, null, w.none, w.none, !0, null, o), this.nodes = [s], this.find = t.findPositions, this.needsBlock = !1 } get top() { return this.nodes[this.open] }addDOM(e) {
    if (e.nodeType == 3) { this.addTextNode(e) }
    else if (e.nodeType == 1) {
      const t = e.getAttribute('style'); const r = t ? this.readStyles(nd(t)) : null; const i = this.top; if (r != null)
        for (let s = 0; s < r.length; s++) this.addPendingMark(r[s]); if (this.addElement(e), r != null)
        for (let s = 0; s < r.length; s++) this.removePendingMark(r[s], i)
    }
  }

  addTextNode(e) {
    let t = e.nodeValue; const r = this.top; if (r.options & Cr || r.inlineContext(e) || /[^ \t\r\n\u000C]/.test(t)) {
      if (r.options & br) {
        r.options & Cr
          ? t = t.replace(/\r\n?/g, `
`)
          : t = t.replace(/\r?\n|\r/g, ' ')
      }
      else if (t = t.replace(/[ \t\r\n\u000C]+/g, ' '), /^[ \t\r\n\u000C]/.test(t) && this.open == this.nodes.length - 1) { const i = r.content[r.content.length - 1]; const s = e.previousSibling; (!i || s && s.nodeName == 'BR' || i.isText && /[ \t\r\n\u000C]$/.test(i.text)) && (t = t.slice(1)) }t && this.insertNode(this.parser.schema.text(t)), this.findInText(e)
    }
    else { this.findInside(e) }
  }

  addElement(e, t) {
    const r = e.nodeName.toLowerCase(); let i; ll.hasOwnProperty(r) && this.parser.normalizeLists && ed(e); const s = this.options.ruleFromNode && this.options.ruleFromNode(e) || (i = this.parser.matchTag(e, this, t)); if (s ? s.ignore : Zc.hasOwnProperty(r)) { this.findInside(e), this.ignoreFallback(e) }
    else if (!s || s.skip || s.closeParent) {
      s && s.closeParent ? this.open = Math.max(0, this.open - 1) : s && s.skip.nodeType && (e = s.skip); let o; const l = this.top; const a = this.needsBlock; if (ol.hasOwnProperty(r)) { o = !0, l.type || (this.needsBlock = !0) }
      else if (!e.firstChild) { this.leafFallback(e); return } this.addAll(e), o && this.sync(l), this.needsBlock = a
    }
    else { this.addElementByRule(e, s, s.consuming === !1 ? i : void 0) }
  }

  leafFallback(e) {
    e.nodeName == 'BR' && this.top.type && this.top.type.inlineContent && this.addTextNode(e.ownerDocument.createTextNode(`
`))
  }

  ignoreFallback(e) { e.nodeName == 'BR' && (!this.top.type || !this.top.type.inlineContent) && this.findPlace(this.parser.schema.text('-')) }readStyles(e) {
    let t = w.none; e:for (let r = 0; r < e.length; r += 2) {
      for (let i = void 0; ;) {
        const s = this.parser.matchStyle(e[r], e[r + 1], this, i); if (!s)
          continue e; if (s.ignore)
          return null; if (t = this.parser.schema.marks[s.mark].create(s.attrs).addToSet(t), s.consuming === !1)
          i = s; else break
      }
    } return t
  }

  addElementByRule(e, t, r) {
    let i, s, o; t.node ? (s = this.parser.schema.nodes[t.node], s.isLeaf ? this.insertNode(s.create(t.attrs)) || this.leafFallback(e) : i = this.enter(s, t.attrs || null, t.preserveWhitespace)) : (o = this.parser.schema.marks[t.mark].create(t.attrs), this.addPendingMark(o)); const l = this.top; if (s && s.isLeaf) { this.findInside(e) }
    else if (r) { this.addElement(e, r) }
    else if (t.getContent) { this.findInside(e), t.getContent(e, this.parser.schema).forEach(a => this.insertNode(a)) }
    else { let a = e; typeof t.contentElement == 'string' ? a = e.querySelector(t.contentElement) : typeof t.contentElement == 'function' ? a = t.contentElement(e) : t.contentElement && (a = t.contentElement), this.findAround(e, a, !0), this.addAll(a) }i && this.sync(l) && this.open--, o && this.removePendingMark(o, l)
  }

  addAll(e, t, r) { let i = t || 0; for (let s = t ? e.childNodes[t] : e.firstChild, o = r == null ? null : e.childNodes[r]; s != o; s = s.nextSibling, ++i) this.findAtPoint(e, i), this.addDOM(s); this.findAtPoint(e, i) }findPlace(e) {
    let t, r; for (let i = this.open; i >= 0; i--) {
      const s = this.nodes[i]; const o = s.findWrapping(e); if (o && (!t || t.length > o.length) && (t = o, r = s, !o.length) || s.solid)
        break
    } if (!t)
      return !1; this.sync(r); for (let i = 0; i < t.length; i++) this.enterInner(t[i], null, !1); return !0
  }

  insertNode(e) { if (e.isInline && this.needsBlock && !this.top.type) { const t = this.textblockFromContext(); t && this.enterInner(t) } if (this.findPlace(e)) { this.closeExtra(); const t = this.top; t.applyPending(e.type), t.match && (t.match = t.match.matchType(e.type)); let r = t.activeMarks; for (let i = 0; i < e.marks.length; i++)(!t.type || t.type.allowsMarkType(e.marks[i].type)) && (r = e.marks[i].addToSet(r)); return t.content.push(e.mark(r)), !0 } return !1 }enter(e, t, r) { const i = this.findPlace(e.create(t)); return i && this.enterInner(e, t, !0, r), i }enterInner(e, t = null, r = !1, i) { this.closeExtra(); const s = this.top; s.applyPending(e), s.match = s.match && s.match.matchType(e); let o = Wo(e, i, s.options); s.options & In && s.content.length == 0 && (o |= In), this.nodes.push(new nn(e, t, s.activeMarks, s.pendingMarks, r, null, o)), this.open++ }closeExtra(e = !1) { let t = this.nodes.length - 1; if (t > this.open) { for (;t > this.open; t--) this.nodes[t - 1].content.push(this.nodes[t].finish(e)); this.nodes.length = this.open + 1 } }finish() { return this.open = 0, this.closeExtra(this.isOpen), this.nodes[0].finish(this.isOpen || this.options.topOpen) }sync(e) {
    for (let t = this.open; t >= 0; t--) {
      if (this.nodes[t] == e)
        return this.open = t, !0
    } return !1
  }

  get currentPos() { this.closeExtra(); let e = 0; for (let t = this.open; t >= 0; t--) { const r = this.nodes[t].content; for (let i = r.length - 1; i >= 0; i--)e += r[i].nodeSize; t && e++ } return e }findAtPoint(e, t) {
    if (this.find)
      for (let r = 0; r < this.find.length; r++) this.find[r].node == e && this.find[r].offset == t && (this.find[r].pos = this.currentPos)
  }

  findInside(e) {
    if (this.find)
      for (let t = 0; t < this.find.length; t++) this.find[t].pos == null && e.nodeType == 1 && e.contains(this.find[t].node) && (this.find[t].pos = this.currentPos)
  }

  findAround(e, t, r) {
    if (e != t && this.find)
      for (let i = 0; i < this.find.length; i++) this.find[i].pos == null && e.nodeType == 1 && e.contains(this.find[i].node) && t.compareDocumentPosition(this.find[i].node) & (r ? 2 : 4) && (this.find[i].pos = this.currentPos)
  }

  findInText(e) {
    if (this.find)
      for (let t = 0; t < this.find.length; t++) this.find[t].node == e && (this.find[t].pos = this.currentPos - (e.nodeValue.length - this.find[t].offset))
  }

  matchesContext(e) {
    if (e.includes('|'))
      return e.split(/\s*\|\s*/).some(this.matchesContext, this); const t = e.split('/'); const r = this.options.context; const i = !this.isOpen && (!r || r.parent.type == this.nodes[0].type); const s = -(r ? r.depth + 1 : 0) + (i ? 0 : 1); const o = (l, a) => {
      for (;l >= 0; l--) {
        const u = t[l]; if (u == '') {
          if (l == t.length - 1 || l == 0)
            continue; for (;a >= s; a--) {
            if (o(l - 1, a))
              return !0
          } return !1
        }
        else {
          const c = a > 0 || a == 0 && i ? this.nodes[a].type : r && a >= s ? r.node(a - s).type : null; if (!c || c.name != u && !c.groups.includes(u))
            return !1; a--
        }
      } return !0
    }; return o(t.length - 1, this.open)
  }

  textblockFromContext() {
    const e = this.options.context; if (e) {
      for (let t = e.depth; t >= 0; t--) {
        const r = e.node(t).contentMatchAt(e.indexAfter(t)).defaultType; if (r && r.isTextblock && r.defaultAttrs)
          return r
      }
    } for (const t in this.parser.schema.nodes) {
      const r = this.parser.schema.nodes[t]; if (r.isTextblock && r.defaultAttrs)
        return r
    }
  }

  addPendingMark(e) { const t = id(e, this.top.pendingMarks); t && this.top.stashMarks.push(t), this.top.pendingMarks = e.addToSet(this.top.pendingMarks) }removePendingMark(e, t) {
    for (let r = this.open; r >= 0; r--) {
      const i = this.nodes[r]; if (i.pendingMarks.lastIndexOf(e) > -1) { i.pendingMarks = e.removeFromSet(i.pendingMarks) }
      else { i.activeMarks = e.removeFromSet(i.activeMarks); const o = i.popFromStashMark(e); o && i.type && i.type.allowsMarkType(o.type) && (i.activeMarks = o.addToSet(i.activeMarks)) } if (i == t)
        break
    }
  }
}; function ed(n) { for (let e = n.firstChild, t = null; e; e = e.nextSibling) { const r = e.nodeType == 1 ? e.nodeName.toLowerCase() : null; r && ll.hasOwnProperty(r) && t ? (t.appendChild(e), e = t) : r == 'li' ? t = e : r && (t = null) } } function td(n, e) { return (n.matches || n.msMatchesSelector || n.webkitMatchesSelector || n.mozMatchesSelector).call(n, e) } function nd(n) { const e = /\s*([\w-]+)\s*:\s*([^;]+)/g; let t; const r = []; for (;t = e.exec(n);)r.push(t[1], t[2].trim()); return r } function qo(n) { const e = {}; for (const t in n)e[t] = n[t]; return e } function rd(n, e) {
  const t = e.schema.nodes; for (const r in t) {
    const i = t[r]; if (!i.allowsMarkType(n))
      continue; const s = []; const o = (l) => {
      s.push(l); for (let a = 0; a < l.edgeCount; a++) {
        const { type: u, next: c } = l.edge(a); if (u == e || !s.includes(c) && o(c))
          return !0
      }
    }; if (o(i.contentMatch))
      return !0
  }
} function id(n, e) {
  for (let t = 0; t < e.length; t++) {
    if (n.eq(e[t]))
      return e[t]
  }
} var X = class {
  constructor(e, t) { this.nodes = e, this.marks = t }serializeFragment(e, t = {}, r) {
    r || (r = Mi(t).createDocumentFragment()); let i = r; const s = []; return e.forEach((o) => {
      if (s.length || o.marks.length) {
        let l = 0; let a = 0; for (;l < s.length && a < o.marks.length;) {
          const u = o.marks[a]; if (!this.marks[u.type.name]) { a++; continue } if (!u.eq(s[l][0]) || u.type.spec.spanning === !1)
            break; l++, a++
        } for (;l < s.length;)i = s.pop()[1]; for (;a < o.marks.length;) { const u = o.marks[a++]; const c = this.serializeMark(u, o.isInline, t); c && (s.push([u, i]), i.appendChild(c.dom), i = c.contentDOM || c.dom) }
      }i.appendChild(this.serializeNodeInner(o, t))
    }), r
  }

  serializeNodeInner(e, t) {
    const { dom: r, contentDOM: i } = X.renderSpec(Mi(t), this.nodes[e.type.name](e)); if (i) {
      if (e.isLeaf)
        throw new RangeError('Content hole not allowed in a leaf node spec'); this.serializeFragment(e.content, t, i)
    } return r
  }

  serializeNode(e, t = {}) { let r = this.serializeNodeInner(e, t); for (let i = e.marks.length - 1; i >= 0; i--) { const s = this.serializeMark(e.marks[i], e.isInline, t); s && ((s.contentDOM || s.dom).appendChild(r), r = s.dom) } return r }serializeMark(e, t, r = {}) { const i = this.marks[e.type.name]; return i && X.renderSpec(Mi(r), i(e, t)) } static renderSpec(e, t, r = null) {
    if (typeof t == 'string')
      return { dom: e.createTextNode(t) }; if (t.nodeType != null)
      return { dom: t }; if (t.dom && t.dom.nodeType != null)
      return t; let i = t[0]; const s = i.indexOf(' '); s > 0 && (r = i.slice(0, s), i = i.slice(s + 1)); let o; const l = r ? e.createElementNS(r, i) : e.createElement(i); const a = t[1]; let u = 1; if (a && typeof a == 'object' && a.nodeType == null && !Array.isArray(a)) { u = 2; for (const c in a) if (a[c] != null) { const d = c.indexOf(' '); d > 0 ? l.setAttributeNS(c.slice(0, d), c.slice(d + 1), a[c]) : l.setAttribute(c, a[c]) } } for (let c = u; c < t.length; c++) {
      const d = t[c]; if (d === 0) {
        if (c < t.length - 1 || c > u)
          throw new RangeError('Content hole must be the only child of its parent node'); return { dom: l, contentDOM: l }
      }
      else {
        const { dom: f, contentDOM: h } = X.renderSpec(e, d, r); if (l.appendChild(f), h) {
          if (o)
            throw new RangeError('Multiple content holes'); o = h
        }
      }
    } return { dom: l, contentDOM: o }
  }

  static fromSchema(e) { return e.cached.domSerializer || (e.cached.domSerializer = new X(this.nodesFromSchema(e), this.marksFromSchema(e))) } static nodesFromSchema(e) { const t = _o(e.nodes); return t.text || (t.text = r => r.text), t } static marksFromSchema(e) { return _o(e.marks) }
}; function _o(n) { const e = {}; for (const t in n) { const r = n[t].spec.toDOM; r && (e[t] = r) } return e } function Mi(n) { return n.document || window.document } const cl = 65535; const dl = 2 ** 16; function sd(n, e) { return n + e * dl } function al(n) { return n & cl } function od(n) { return (n - (n & cl)) / dl } const fl = 1; const hl = 2; const Sr = 4; const pl = 8; const Ln = class {constructor(e, t, r) { this.pos = e, this.delInfo = t, this.recover = r } get deleted() { return (this.delInfo & pl) > 0 } get deletedBefore() { return (this.delInfo & (fl | Sr)) > 0 } get deletedAfter() { return (this.delInfo & (hl | Sr)) > 0 } get deletedAcross() { return (this.delInfo & Sr) > 0 }}; var ye = class {
  constructor(e, t = !1) {
    if (this.ranges = e, this.inverted = t, !e.length && ye.empty)
      return ye.empty
  }

  recover(e) {
    let t = 0; const r = al(e); if (!this.inverted)
      for (let i = 0; i < r; i++)t += this.ranges[i * 3 + 2] - this.ranges[i * 3 + 1]; return this.ranges[r * 3] + t + od(e)
  }

  mapResult(e, t = 1) { return this._map(e, t, !1) }map(e, t = 1) { return this._map(e, t, !0) }_map(e, t, r) {
    let i = 0; const s = this.inverted ? 2 : 1; const o = this.inverted ? 1 : 2; for (let l = 0; l < this.ranges.length; l += 3) {
      const a = this.ranges[l] - (this.inverted ? i : 0); if (a > e)
        break; const u = this.ranges[l + s]; const c = this.ranges[l + o]; const d = a + u; if (e <= d) {
        const f = u ? e == a ? -1 : e == d ? 1 : t : t; const h = a + i + (f < 0 ? 0 : c); if (r)
          return h; const p = e == (t < 0 ? a : d) ? null : sd(l / 3, e - a); let m = e == a ? hl : e == d ? fl : Sr; return (t < 0 ? e != a : e != d) && (m |= pl), new Ln(h, m, p)
      }i += c - u
    } return r ? e + i : new Ln(e + i, 0, null)
  }

  touches(e, t) {
    let r = 0; const i = al(t); const s = this.inverted ? 2 : 1; const o = this.inverted ? 1 : 2; for (let l = 0; l < this.ranges.length; l += 3) {
      const a = this.ranges[l] - (this.inverted ? r : 0); if (a > e)
        break; const u = this.ranges[l + s]; const c = a + u; if (e <= c && l == i * 3)
        return !0; r += this.ranges[l + o] - u
    } return !1
  }

  forEach(e) { const t = this.inverted ? 2 : 1; const r = this.inverted ? 1 : 2; for (let i = 0, s = 0; i < this.ranges.length; i += 3) { const o = this.ranges[i]; const l = o - (this.inverted ? s : 0); const a = o + (this.inverted ? 0 : s); const u = this.ranges[i + t]; const c = this.ranges[i + r]; e(l, l + u, a, a + c), s += c - u } }invert() { return new ye(this.ranges, !this.inverted) }toString() { return (this.inverted ? '-' : '') + JSON.stringify(this.ranges) } static offset(e) { return e == 0 ? ye.empty : new ye(e < 0 ? [0, -e, 0] : [0, 0, e]) }
}; ye.empty = new ye([]); var It = class {
  constructor(e = [], t, r = 0, i = e.length) { this.maps = e, this.mirror = t, this.from = r, this.to = i }slice(e = 0, t = this.maps.length) { return new It(this.maps, this.mirror, e, t) }copy() { return new It(this.maps.slice(), this.mirror && this.mirror.slice(), this.from, this.to) }appendMap(e, t) { this.to = this.maps.push(e), t != null && this.setMirror(this.maps.length - 1, t) }appendMapping(e) { for (let t = 0, r = this.maps.length; t < e.maps.length; t++) { const i = e.getMirror(t); this.appendMap(e.maps[t], i != null && i < t ? r + i : void 0) } }getMirror(e) {
    if (this.mirror) {
      for (let t = 0; t < this.mirror.length; t++) {
        if (this.mirror[t] == e)
          return this.mirror[t + (t % 2 ? -1 : 1)]
      }
    }
  }

  setMirror(e, t) { this.mirror || (this.mirror = []), this.mirror.push(e, t) }appendMappingInverted(e) { for (let t = e.maps.length - 1, r = this.maps.length + e.maps.length; t >= 0; t--) { const i = e.getMirror(t); this.appendMap(e.maps[t].invert(), i != null && i > t ? r - i - 1 : void 0) } }invert() { const e = new It(); return e.appendMappingInverted(this), e }map(e, t = 1) {
    if (this.mirror)
      return this._map(e, t, !0); for (let r = this.from; r < this.to; r++)e = this.maps[r].map(e, t); return e
  }

  mapResult(e, t = 1) { return this._map(e, t, !1) }_map(e, t, r) { let i = 0; for (let s = this.from; s < this.to; s++) { const o = this.maps[s]; const l = o.mapResult(e, t); if (l.recover != null) { const a = this.getMirror(s); if (a != null && a > s && a < this.to) { s = a, e = this.maps[a].recover(l.recover); continue } }i |= l.delInfo, e = l.pos } return r ? e : new Ln(e, i, null) }
}; const wi = Object.create(null); const ze = class {
  getMap() { return ye.empty }merge(e) { return null } static fromJSON(e, t) {
    if (!t || !t.stepType)
      throw new RangeError('Invalid input for Step.fromJSON'); const r = wi[t.stepType]; if (!r)
      throw new RangeError(`No step type ${t.stepType} defined`); return r.fromJSON(e, t)
  }

  static jsonID(e, t) {
    if (e in wi)
      throw new RangeError(`Duplicate use of step JSON ID ${e}`); return wi[e] = t, t.prototype.jsonID = e, t
  }
}; var ae = class {
  constructor(e, t) { this.doc = e, this.failed = t } static ok(e) { return new ae(e, null) } static fail(e) { return new ae(null, e) } static fromReplace(e, t, r, i) {
    try { return ae.ok(e.replace(t, r, i)) }
    catch (s) {
      if (s instanceof Re)
        return ae.fail(s.message); throw s
    }
  }
}; function Pi(n, e, t) { const r = []; for (let i = 0; i < n.childCount; i++) { let s = n.child(i); s.content.size && (s = s.copy(Pi(s.content, e, s))), s.isInline && (s = e(s, t, i)), r.push(s) } return y.fromArray(r) } var Le = class extends ze {
  constructor(e, t, r) { super(), this.from = e, this.to = t, this.mark = r }apply(e) { const t = e.slice(this.from, this.to); const r = e.resolve(this.from); const i = r.node(r.sharedDepth(this.to)); const s = new b(Pi(t.content, (o, l) => !o.isAtom || !l.type.allowsMarkType(this.mark.type) ? o : o.mark(this.mark.addToSet(o.marks)), i), t.openStart, t.openEnd); return ae.fromReplace(e, this.from, this.to, s) }invert() { return new Me(this.from, this.to, this.mark) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); return t.deleted && r.deleted || t.pos >= r.pos ? null : new Le(t.pos, r.pos, this.mark) }merge(e) { return e instanceof Le && e.mark.eq(this.mark) && this.from <= e.to && this.to >= e.from ? new Le(Math.min(this.from, e.from), Math.max(this.to, e.to), this.mark) : null }toJSON() { return { stepType: 'addMark', mark: this.mark.toJSON(), from: this.from, to: this.to } } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number')
      throw new RangeError('Invalid input for AddMarkStep.fromJSON'); return new Le(t.from, t.to, e.markFromJSON(t.mark))
  }
}; ze.jsonID('addMark', Le); var Me = class extends ze {
  constructor(e, t, r) { super(), this.from = e, this.to = t, this.mark = r }apply(e) { const t = e.slice(this.from, this.to); const r = new b(Pi(t.content, i => i.mark(this.mark.removeFromSet(i.marks)), e), t.openStart, t.openEnd); return ae.fromReplace(e, this.from, this.to, r) }invert() { return new Le(this.from, this.to, this.mark) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); return t.deleted && r.deleted || t.pos >= r.pos ? null : new Me(t.pos, r.pos, this.mark) }merge(e) { return e instanceof Me && e.mark.eq(this.mark) && this.from <= e.to && this.to >= e.from ? new Me(Math.min(this.from, e.from), Math.max(this.to, e.to), this.mark) : null }toJSON() { return { stepType: 'removeMark', mark: this.mark.toJSON(), from: this.from, to: this.to } } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number')
      throw new RangeError('Invalid input for RemoveMarkStep.fromJSON'); return new Me(t.from, t.to, e.markFromJSON(t.mark))
  }
}; ze.jsonID('removeMark', Me); var j = class extends ze {
  constructor(e, t, r, i = !1) { super(), this.from = e, this.to = t, this.slice = r, this.structure = i }apply(e) { return this.structure && Bi(e, this.from, this.to) ? ae.fail('Structure replace would overwrite content') : ae.fromReplace(e, this.from, this.to, this.slice) }getMap() { return new ye([this.from, this.to - this.from, this.slice.size]) }invert(e) { return new j(this.from, this.from + this.slice.size, e.slice(this.from, this.to)) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); return t.deletedAcross && r.deletedAcross ? null : new j(t.pos, Math.max(t.pos, r.pos), this.slice) }merge(e) {
    if (!(e instanceof j) || e.structure || this.structure)
      return null; if (this.from + this.slice.size == e.from && !this.slice.openEnd && !e.slice.openStart) { const t = this.slice.size + e.slice.size == 0 ? b.empty : new b(this.slice.content.append(e.slice.content), this.slice.openStart, e.slice.openEnd); return new j(this.from, this.to + (e.to - e.from), t, this.structure) }
    else if (e.to == this.from && !this.slice.openStart && !e.slice.openEnd) { const t = this.slice.size + e.slice.size == 0 ? b.empty : new b(e.slice.content.append(this.slice.content), e.slice.openStart, this.slice.openEnd); return new j(e.from, this.to, t, this.structure) }
    else { return null }
  }

  toJSON() { const e = { stepType: 'replace', from: this.from, to: this.to }; return this.slice.size && (e.slice = this.slice.toJSON()), this.structure && (e.structure = !0), e } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number')
      throw new RangeError('Invalid input for ReplaceStep.fromJSON'); return new j(t.from, t.to, b.fromJSON(e, t.slice), !!t.structure)
  }
}; ze.jsonID('replace', j); var z = class extends ze {
  constructor(e, t, r, i, s, o, l = !1) { super(), this.from = e, this.to = t, this.gapFrom = r, this.gapTo = i, this.slice = s, this.insert = o, this.structure = l }apply(e) {
    if (this.structure && (Bi(e, this.from, this.gapFrom) || Bi(e, this.gapTo, this.to)))
      return ae.fail('Structure gap-replace would overwrite content'); const t = e.slice(this.gapFrom, this.gapTo); if (t.openStart || t.openEnd)
      return ae.fail('Gap is not a flat range'); const r = this.slice.insertAt(this.insert, t.content); return r ? ae.fromReplace(e, this.from, this.to, r) : ae.fail('Content does not fit in gap')
  }

  getMap() { return new ye([this.from, this.gapFrom - this.from, this.insert, this.gapTo, this.to - this.gapTo, this.slice.size - this.insert]) }invert(e) { const t = this.gapTo - this.gapFrom; return new z(this.from, this.from + this.slice.size + t, this.from + this.insert, this.from + this.insert + t, e.slice(this.from, this.to).removeBetween(this.gapFrom - this.from, this.gapTo - this.from), this.gapFrom - this.from, this.structure) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); const i = e.map(this.gapFrom, -1); const s = e.map(this.gapTo, 1); return t.deletedAcross && r.deletedAcross || i < t.pos || s > r.pos ? null : new z(t.pos, r.pos, i, s, this.slice, this.insert, this.structure) }toJSON() { const e = { stepType: 'replaceAround', from: this.from, to: this.to, gapFrom: this.gapFrom, gapTo: this.gapTo, insert: this.insert }; return this.slice.size && (e.slice = this.slice.toJSON()), this.structure && (e.structure = !0), e } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number' || typeof t.gapFrom != 'number' || typeof t.gapTo != 'number' || typeof t.insert != 'number')
      throw new RangeError('Invalid input for ReplaceAroundStep.fromJSON'); return new z(t.from, t.to, t.gapFrom, t.gapTo, b.fromJSON(e, t.slice), t.insert, !!t.structure)
  }
}; ze.jsonID('replaceAround', z); function Bi(n, e, t) {
  const r = n.resolve(e); let i = t - e; let s = r.depth; for (;i > 0 && s > 0 && r.indexAfter(s) == r.node(s).childCount;)s--, i--; if (i > 0) {
    let o = r.node(s).maybeChild(r.indexAfter(s)); for (;i > 0;) {
      if (!o || o.isLeaf)
        return !0; o = o.firstChild, i--
    }
  } return !1
} function ld(n, e, t, r) {
  const i = []; const s = []; let o; let l; n.doc.nodesBetween(e, t, (a, u, c) => {
    if (!a.isInline)
      return; const d = a.marks; if (!r.isInSet(d) && c.type.allowsMarkType(r.type)) { const f = Math.max(u, e); const h = Math.min(u + a.nodeSize, t); const p = r.addToSet(d); for (let m = 0; m < d.length; m++)d[m].isInSet(p) || (o && o.to == f && o.mark.eq(d[m]) ? o.to = h : i.push(o = new Me(f, h, d[m]))); l && l.to == f ? l.to = h : s.push(l = new Le(f, h, r)) }
  }), i.forEach(a => n.step(a)), s.forEach(a => n.step(a))
} function ad(n, e, t, r) {
  const i = []; let s = 0; n.doc.nodesBetween(e, t, (o, l) => {
    if (!o.isInline)
      return; s++; let a = null; if (r instanceof ft) { let u = o.marks; let c; for (;c = r.isInSet(u);)(a || (a = [])).push(c), u = c.removeFromSet(u) }
    else { r ? r.isInSet(o.marks) && (a = [r]) : a = o.marks } if (a && a.length) { const u = Math.min(l + o.nodeSize, t); for (let c = 0; c < a.length; c++) { const d = a[c]; let f; for (let h = 0; h < i.length; h++) { const p = i[h]; p.step == s - 1 && d.eq(i[h].style) && (f = p) }f ? (f.to = u, f.step = s) : i.push({ style: d, from: Math.max(l, e), to: u, step: s }) } }
  }), i.forEach(o => n.step(new Me(o.from, o.to, o.style)))
} function ud(n, e, t, r = t.contentMatch) {
  const i = n.doc.nodeAt(e); const s = []; let o = e + 1; for (let l = 0; l < i.childCount; l++) {
    const a = i.child(l); const u = o + a.nodeSize; const c = r.matchType(a.type); if (!c) { s.push(new j(o, u, b.empty)) }
    else { r = c; for (let d = 0; d < a.marks.length; d++)t.allowsMarkType(a.marks[d].type) || n.step(new Me(o, u, a.marks[d])) }o = u
  } if (!r.validEnd) { const l = r.fillBefore(y.empty, !0); n.replace(o, o, new b(l, 0, 0)) } for (let l = s.length - 1; l >= 0; l--)n.step(s[l])
} function cd(n, e, t) { return (e == 0 || n.canReplace(e, n.childCount)) && (t == n.childCount || n.canReplace(0, t)) } function Qe(n) {
  const t = n.parent.content.cutByIndex(n.startIndex, n.endIndex); for (let r = n.depth; ;--r) {
    const i = n.$from.node(r); const s = n.$from.index(r); const o = n.$to.indexAfter(r); if (r < n.depth && i.canReplace(s, o, t))
      return r; if (r == 0 || i.type.spec.isolating || !cd(i, s, o))
      break
  } return null
} function dd(n, e, t) { const { $from: r, $to: i, depth: s } = e; const o = r.before(s + 1); const l = i.after(s + 1); let a = o; let u = l; let c = y.empty; let d = 0; for (let p = s, m = !1; p > t; p--)m || r.index(p) > 0 ? (m = !0, c = y.from(r.node(p).copy(c)), d++) : a--; let f = y.empty; let h = 0; for (let p = s, m = !1; p > t; p--)m || i.after(p + 1) < i.end(p) ? (m = !0, f = y.from(i.node(p).copy(f)), h++) : u++; n.step(new z(a, u, o, l, new b(c.append(f), d, h), c.size - d, !0)) } function an(n, e, t = null, r = n) { const i = fd(n, e); const s = i && hd(r, e); return s ? i.map(ul).concat({ type: e, attrs: t }).concat(s.map(ul)) : null } function ul(n) { return { type: n, attrs: null } } function fd(n, e) {
  const { parent: t, startIndex: r, endIndex: i } = n; const s = t.contentMatchAt(r).findWrapping(e); if (!s)
    return null; const o = s.length ? s[0] : e; return t.canReplaceWith(r, i, o) ? s : null
} function hd(n, e) {
  const { parent: t, startIndex: r, endIndex: i } = n; const s = t.child(r); const o = e.contentMatch.findWrapping(s.type); if (!o)
    return null; let a = (o.length ? o[o.length - 1] : e).contentMatch; for (let u = r; a && u < i; u++)a = a.matchType(t.child(u).type); return !a || !a.validEnd ? null : o
} function pd(n, e, t) {
  let r = y.empty; for (let o = t.length - 1; o >= 0; o--) {
    if (r.size) {
      const l = t[o].type.contentMatch.matchFragment(r); if (!l || !l.validEnd)
        throw new RangeError('Wrapper type given to Transform.wrap does not form valid content of its parent wrapper')
    }r = y.from(t[o].type.create(t[o].attrs, r))
  } const i = e.start; const s = e.end; n.step(new z(i, s, i, s, new b(r, 0, 0), t.length, !0))
} function md(n, e, t, r, i) {
  if (!r.isTextblock)
    throw new RangeError('Type given to setBlockType should be a textblock'); const s = n.steps.length; n.doc.nodesBetween(e, t, (o, l) => { if (o.isTextblock && !o.hasMarkup(r, i) && gd(n.doc, n.mapping.slice(s).map(l), r)) { n.clearIncompatible(n.mapping.slice(s).map(l, 1), r); const a = n.mapping.slice(s); const u = a.map(l, 1); const c = a.map(l + o.nodeSize, 1); return n.step(new z(u, c, u + 1, c - 1, new b(y.from(r.create(i, null, o.marks)), 0, 0), 1, !0)), !1 } })
} function gd(n, e, t) { const r = n.resolve(e); const i = r.index(); return r.parent.canReplaceWith(i, i + 1, t) } function yd(n, e, t, r, i) {
  const s = n.doc.nodeAt(e); if (!s)
    throw new RangeError('No node at given position'); t || (t = s.type); const o = t.create(r, null, i || s.marks); if (s.isLeaf)
    return n.replaceWith(e, e + s.nodeSize, o); if (!t.validContent(s.content))
    throw new RangeError(`Invalid content for node type ${t.name}`); n.step(new z(e, e + s.nodeSize, e + 1, e + s.nodeSize - 1, new b(y.from(o), 0, 0), 1, !0))
} function Oe(n, e, t = 1, r) {
  const i = n.resolve(e); const s = i.depth - t; const o = r && r[r.length - 1] || i.parent; if (s < 0 || i.parent.type.spec.isolating || !i.parent.canReplace(i.index(), i.parent.childCount) || !o.type.validContent(i.parent.content.cutByIndex(i.index(), i.parent.childCount)))
    return !1; for (let u = i.depth - 1, c = t - 2; u > s; u--, c--) {
    const d = i.node(u); const f = i.index(u); if (d.type.spec.isolating)
      return !1; let h = d.content.cutByIndex(f, d.childCount); const p = r && r[c] || d; if (p != d && (h = h.replaceChild(0, p.type.create(p.attrs))), !d.canReplace(f + 1, d.childCount) || !p.type.validContent(h))
      return !1
  } const l = i.indexAfter(s); const a = r && r[0]; return i.node(s).canReplaceWith(l, l, a ? a.type : i.node(s + 1).type)
} function Dd(n, e, t = 1, r) { const i = n.doc.resolve(e); let s = y.empty; let o = y.empty; for (let l = i.depth, a = i.depth - t, u = t - 1; l > a; l--, u--) { s = y.from(i.node(l).copy(s)); const c = r && r[u]; o = y.from(c ? c.type.create(c.attrs, o) : i.node(l).copy(o)) }n.step(new j(e, e, new b(s.append(o), t, t), !0)) } function Pt(n, e) { const t = n.resolve(e); const r = t.index(); return bd(t.nodeBefore, t.nodeAfter) && t.parent.canReplace(r, r + 1) } function bd(n, e) { return !!(n && e && !n.isLeaf && n.canAppend(e)) } function Cd(n, e, t) { const r = new j(e - t, e + t, b.empty, !0); n.step(r) } function kd(n, e, t) {
  const r = n.resolve(e); if (r.parent.canReplaceWith(r.index(), r.index(), t))
    return e; if (r.parentOffset == 0) {
    for (let i = r.depth - 1; i >= 0; i--) {
      const s = r.index(i); if (r.node(i).canReplaceWith(s, s, t))
        return r.before(i + 1); if (s > 0)
        return null
    }
  } if (r.parentOffset == r.parent.content.size) {
    for (let i = r.depth - 1; i >= 0; i--) {
      const s = r.indexAfter(i); if (r.node(i).canReplaceWith(s, s, t))
        return r.after(i + 1); if (s < r.node(i).childCount)
        return null
    }
  } return null
} function ml(n, e, t) {
  const r = n.resolve(e); if (!t.content.size)
    return e; let i = t.content; for (let s = 0; s < t.openStart; s++)i = i.firstChild.content; for (let s = 1; s <= (t.openStart == 0 && t.size ? 2 : 1); s++) {
    for (let o = r.depth; o >= 0; o--) {
      const l = o == r.depth ? 0 : r.pos <= (r.start(o + 1) + r.end(o + 1)) / 2 ? -1 : 1; const a = r.index(o) + (l > 0 ? 1 : 0); const u = r.node(o); let c = !1; if (s == 1) { c = u.canReplace(a, a, i) }
      else { const d = u.contentMatchAt(a).findWrapping(i.firstChild.type); c = d && u.canReplaceWith(a, a, d[0]) } if (c)
        return l == 0 ? r.pos : l < 0 ? r.before(o + 1) : r.after(o + 1)
    }
  } return null
} function xr(n, e, t = e, r = b.empty) {
  if (e == t && !r.size)
    return null; const i = n.resolve(e); const s = n.resolve(t); return gl(i, s, r) ? new j(e, t, r) : new Ii(i, s, r).fit()
} function gl(n, e, t) { return !t.openStart && !t.openEnd && n.start() == e.start() && n.parent.canReplace(n.index(), e.index(), t.content) } var Ii = class {
  constructor(e, t, r) { this.$from = e, this.$to = t, this.unplaced = r, this.frontier = [], this.placed = y.empty; for (let i = 0; i <= e.depth; i++) { const s = e.node(i); this.frontier.push({ type: s.type, match: s.contentMatchAt(e.indexAfter(i)) }) } for (let i = e.depth; i > 0; i--) this.placed = y.from(e.node(i).copy(this.placed)) } get depth() { return this.frontier.length - 1 }fit() {
    for (;this.unplaced.size;) { const u = this.findFittable(); u ? this.placeNodes(u) : this.openMore() || this.dropNode() } const e = this.mustMoveInline(); const t = this.placed.size - this.depth - this.$from.depth; const r = this.$from; const i = this.close(e < 0 ? this.$to : r.doc.resolve(e)); if (!i)
      return null; let s = this.placed; let o = r.depth; let l = i.depth; for (;o && l && s.childCount == 1;)s = s.firstChild.content, o--, l--; const a = new b(s, o, l); return e > -1 ? new z(r.pos, e, this.$to.pos, this.$to.end(), a, t) : a.size || r.pos != this.$to.pos ? new j(r.pos, i.pos, a) : null
  }

  findFittable() {
    for (let e = 1; e <= 2; e++) {
      for (let t = this.unplaced.openStart; t >= 0; t--) {
        let r; let i = null; t ? (i = Fi(this.unplaced.content, t - 1).firstChild, r = i.content) : r = this.unplaced.content; const s = r.firstChild; for (let o = this.depth; o >= 0; o--) {
          const { type: l, match: a } = this.frontier[o]; let u; let c = null; if (e == 1 && (s ? a.matchType(s.type) || (c = a.fillBefore(y.from(s), !1)) : i && l.compatibleContent(i.type)))
            return { sliceDepth: t, frontierDepth: o, parent: i, inject: c }; if (e == 2 && s && (u = a.findWrapping(s.type)))
            return { sliceDepth: t, frontierDepth: o, parent: i, wrap: u }; if (i && a.matchType(i.type))
            break
        }
      }
    }
  }

  openMore() { const { content: e, openStart: t, openEnd: r } = this.unplaced; const i = Fi(e, t); return !i.childCount || i.firstChild.isLeaf ? !1 : (this.unplaced = new b(e, t + 1, Math.max(r, i.size + t >= e.size - r ? t + 1 : 0)), !0) }dropNode() {
    const { content: e, openStart: t, openEnd: r } = this.unplaced; const i = Fi(e, t); if (i.childCount <= 1 && t > 0) { const s = e.size - t <= t + i.size; this.unplaced = new b(Pn(e, t - 1, 1), t - 1, s ? t - 1 : r) }
    else { this.unplaced = new b(Pn(e, t, 1), t, r) }
  }

  placeNodes({ sliceDepth: e, frontierDepth: t, parent: r, inject: i, wrap: s }) {
    for (;this.depth > t;) this.closeFrontierNode(); if (s)
      for (let m = 0; m < s.length; m++) this.openFrontierNode(s[m]); const o = this.unplaced; const l = r ? r.content : o.content; const a = o.openStart - e; let u = 0; const c = []; let { match: d, type: f } = this.frontier[t]; if (i) { for (let m = 0; m < i.childCount; m++)c.push(i.child(m)); d = d.matchFragment(i) } let h = l.size + e - (o.content.size - o.openEnd); for (;u < l.childCount;) {
      const m = l.child(u); const g = d.matchType(m.type); if (!g)
        break; u++, (u > 1 || a == 0 || m.content.size) && (d = g, c.push(yl(m.mark(f.allowedMarks(m.marks)), u == 1 ? a : 0, u == l.childCount ? h : -1)))
    } const p = u == l.childCount; p || (h = -1), this.placed = Rn(this.placed, t, y.from(c)), this.frontier[t].match = d, p && h < 0 && r && r.type == this.frontier[this.depth].type && this.frontier.length > 1 && this.closeFrontierNode(); for (let m = 0, g = l; m < h; m++) { const D = g.lastChild; this.frontier.push({ type: D.type, match: D.contentMatchAt(D.childCount) }), g = D.content } this.unplaced = p ? e == 0 ? b.empty : new b(Pn(o.content, e - 1, 1), e - 1, h < 0 ? o.openEnd : e - 1) : new b(Pn(o.content, e, u), o.openStart, o.openEnd)
  }

  mustMoveInline() {
    if (!this.$to.parent.isTextblock)
      return -1; const e = this.frontier[this.depth]; let t; if (!e.type.isTextblock || !vi(this.$to, this.$to.depth, e.type, e.match, !1) || this.$to.depth == this.depth && (t = this.findCloseLevel(this.$to)) && t.depth == this.depth)
      return -1; let { depth: r } = this.$to; let i = this.$to.after(r); for (;r > 1 && i == this.$to.end(--r);)++i; return i
  }

  findCloseLevel(e) {
    e:for (let t = Math.min(this.depth, e.depth); t >= 0; t--) {
      const { match: r, type: i } = this.frontier[t]; const s = t < e.depth && e.end(t + 1) == e.pos + (e.depth - (t + 1)); const o = vi(e, t, i, r, s); if (o) {
        for (let l = t - 1; l >= 0; l--) {
          const { match: a, type: u } = this.frontier[l]; const c = vi(e, l, u, a, !0); if (!c || c.childCount)
            continue e
        } return { depth: t, fit: o, move: s ? e.doc.resolve(e.after(t + 1)) : e }
      }
    }
  }

  close(e) {
    const t = this.findCloseLevel(e); if (!t)
      return null; for (;this.depth > t.depth;) this.closeFrontierNode(); t.fit.childCount && (this.placed = Rn(this.placed, t.depth, t.fit)), e = t.move; for (let r = t.depth + 1; r <= e.depth; r++) { const i = e.node(r); const s = i.type.contentMatch.fillBefore(i.content, !0, e.index(r)); this.openFrontierNode(i.type, i.attrs, s) } return e
  }

  openFrontierNode(e, t = null, r) { const i = this.frontier[this.depth]; i.match = i.match.matchType(e), this.placed = Rn(this.placed, this.depth, y.from(e.create(t, r))), this.frontier.push({ type: e, match: e.contentMatch }) }closeFrontierNode() { const t = this.frontier.pop().match.fillBefore(y.empty, !0); t.childCount && (this.placed = Rn(this.placed, this.frontier.length, t)) }
}; function Pn(n, e, t) { return e == 0 ? n.cutByIndex(t, n.childCount) : n.replaceChild(0, n.firstChild.copy(Pn(n.firstChild.content, e - 1, t))) } function Rn(n, e, t) { return e == 0 ? n.append(t) : n.replaceChild(n.childCount - 1, n.lastChild.copy(Rn(n.lastChild.content, e - 1, t))) } function Fi(n, e) { for (let t = 0; t < e; t++)n = n.firstChild.content; return n } function yl(n, e, t) {
  if (e <= 0)
    return n; let r = n.content; return e > 1 && (r = r.replaceChild(0, yl(r.firstChild, e - 1, r.childCount == 1 ? t - 1 : 0))), e > 0 && (r = n.type.contentMatch.fillBefore(r).append(r), t <= 0 && (r = r.append(n.type.contentMatch.matchFragment(r).fillBefore(y.empty, !0)))), n.copy(r)
} function vi(n, e, t, r, i) {
  const s = n.node(e); const o = i ? n.indexAfter(e) : n.index(e); if (o == s.childCount && !t.compatibleContent(s.type))
    return null; const l = r.fillBefore(s.content, !0, o); return l && !Sd(t, s.content, o) ? l : null
} function Sd(n, e, t) {
  for (let r = t; r < e.childCount; r++) {
    if (!n.allowsMarks(e.child(r).marks))
      return !0
  } return !1
} function xd(n) { return n.spec.defining || n.spec.definingForContent } function Ed(n, e, t, r) {
  if (!r.size)
    return n.deleteRange(e, t); const i = n.doc.resolve(e); const s = n.doc.resolve(t); if (gl(i, s, r))
    return n.step(new j(e, t, r)); const o = bl(i, n.doc.resolve(t)); o[o.length - 1] == 0 && o.pop(); let l = -(i.depth + 1); o.unshift(l); for (let f = i.depth, h = i.pos - 1; f > 0; f--, h--) {
    const p = i.node(f).type.spec; if (p.defining || p.definingAsContext || p.isolating)
      break; o.includes(f) ? l = f : i.before(f) == h && o.splice(1, 0, -f)
  } const a = o.indexOf(l); const u = []; let c = r.openStart; for (let f = r.content, h = 0; ;h++) {
    const p = f.firstChild; if (u.push(p), h == r.openStart)
      break; f = p.content
  } for (let f = c - 1; f >= 0; f--) {
    const h = u[f].type; const p = xd(h); if (p && i.node(a).type != h)
      c = f; else if (p || !h.isTextblock)
      break
  } for (let f = r.openStart; f >= 0; f--) {
    const h = (f + c + 1) % (r.openStart + 1); const p = u[h]; if (p) {
      for (let m = 0; m < o.length; m++) {
        let g = o[(m + a) % o.length]; let D = !0; g < 0 && (D = !1, g = -g); const S = i.node(g - 1); const F = i.index(g - 1); if (S.canReplaceWith(F, F, p.type, p.marks))
          return n.replace(i.before(g), D ? s.after(g) : t, new b(Dl(r.content, 0, r.openStart, h), h, r.openEnd))
      }
    }
  } const d = n.steps.length; for (let f = o.length - 1; f >= 0 && (n.replace(e, t, r), !(n.steps.length > d)); f--) { const h = o[f]; h < 0 || (e = i.before(h), t = s.after(h)) }
} function Dl(n, e, t, r, i) { if (e < t) { const s = n.firstChild; n = n.replaceChild(0, s.copy(Dl(s.content, e + 1, t, r, s))) } if (e > r) { const s = i.contentMatchAt(0); const o = s.fillBefore(n).append(n); n = o.append(s.matchFragment(o).fillBefore(y.empty, !0)) } return n } function Ad(n, e, t, r) { if (!r.isInline && e == t && n.doc.resolve(e).parent.content.size) { const i = kd(n.doc, e, r.type); i != null && (e = t = i) }n.replaceRange(e, t, new b(y.from(r), 0, 0)) } function Md(n, e, t) {
  const r = n.doc.resolve(e); const i = n.doc.resolve(t); const s = bl(r, i); for (let o = 0; o < s.length; o++) {
    const l = s[o]; const a = o == s.length - 1; if (a && l == 0 || r.node(l).type.contentMatch.validEnd)
      return n.delete(r.start(l), i.end(l)); if (l > 0 && (a || r.node(l - 1).canReplace(r.index(l - 1), i.indexAfter(l - 1))))
      return n.delete(r.before(l), i.after(l))
  } for (let o = 1; o <= r.depth && o <= i.depth; o++) {
    if (e - r.start(o) == r.depth - o && t > r.end(o) && i.end(o) - t != i.depth - o)
      return n.delete(r.before(o), t)
  } n.delete(e, t)
} function bl(n, e) {
  const t = []; const r = Math.min(n.depth, e.depth); for (let i = r; i >= 0; i--) {
    const s = n.start(i); if (s < n.pos - (n.depth - i) || e.end(i) > e.pos + (e.depth - i) || n.node(i).type.spec.isolating || e.node(i).type.spec.isolating)
      break; (s == e.start(i) || i == n.depth && i == e.depth && n.parent.inlineContent && e.parent.inlineContent && i && e.start(i - 1) == s - 1) && t.push(i)
  } return t
} let on = class extends Error {}; on = function n(e) { const t = Error.call(this, e); return t.__proto__ = n.prototype, t }; on.prototype = Object.create(Error.prototype); on.prototype.constructor = on; on.prototype.name = 'TransformError'; const ln = class {
  constructor(e) { this.doc = e, this.steps = [], this.docs = [], this.mapping = new It() } get before() { return this.docs.length ? this.docs[0] : this.doc }step(e) {
    const t = this.maybeStep(e); if (t.failed)
      throw new on(t.failed); return this
  }

  maybeStep(e) { const t = e.apply(this.doc); return t.failed || this.addStep(e, t.doc), t } get docChanged() { return this.steps.length > 0 }addStep(e, t) { this.docs.push(this.doc), this.steps.push(e), this.mapping.appendMap(e.getMap()), this.doc = t }replace(e, t = e, r = b.empty) { const i = xr(this.doc, e, t, r); return i && this.step(i), this }replaceWith(e, t, r) { return this.replace(e, t, new b(y.from(r), 0, 0)) }delete(e, t) { return this.replace(e, t, b.empty) }insert(e, t) { return this.replaceWith(e, e, t) }replaceRange(e, t, r) { return Ed(this, e, t, r), this }replaceRangeWith(e, t, r) { return Ad(this, e, t, r), this }deleteRange(e, t) { return Md(this, e, t), this }lift(e, t) { return dd(this, e, t), this }join(e, t = 1) { return Cd(this, e, t), this }wrap(e, t) { return pd(this, e, t), this }setBlockType(e, t = e, r, i = null) { return md(this, e, t, r, i), this }setNodeMarkup(e, t, r = null, i = []) { return yd(this, e, t, r, i), this }split(e, t = 1, r) { return Dd(this, e, t, r), this }addMark(e, t, r) { return ld(this, e, t, r), this }removeMark(e, t, r) { return ad(this, e, t, r), this }clearIncompatible(e, t, r) { return ud(this, e, t, r), this }
}; const Ri = Object.create(null); const M = class {
  constructor(e, t, r) { this.$anchor = e, this.$head = t, this.ranges = r || [new zi(e.min(t), e.max(t))] } get anchor() { return this.$anchor.pos } get head() { return this.$head.pos } get from() { return this.$from.pos } get to() { return this.$to.pos } get $from() { return this.ranges[0].$from } get $to() { return this.ranges[0].$to } get empty() {
    const e = this.ranges; for (let t = 0; t < e.length; t++) {
      if (e[t].$from.pos != e[t].$to.pos)
        return !1
    } return !0
  }

  content() { return this.$from.doc.slice(this.from, this.to, !0) }replace(e, t = b.empty) { let r = t.content.lastChild; let i = null; for (let l = 0; l < t.openEnd; l++)i = r, r = r.lastChild; const s = e.steps.length; const o = this.ranges; for (let l = 0; l < o.length; l++) { const { $from: a, $to: u } = o[l]; const c = e.mapping.slice(s); e.replaceRange(c.map(a.pos), c.map(u.pos), l ? b.empty : t), l == 0 && Sl(e, s, (r ? r.isInline : i && i.isTextblock) ? -1 : 1) } }replaceWith(e, t) { const r = e.steps.length; const i = this.ranges; for (let s = 0; s < i.length; s++) { const { $from: o, $to: l } = i[s]; const a = e.mapping.slice(r); const u = a.map(o.pos); const c = a.map(l.pos); s ? e.deleteRange(u, c) : (e.replaceRangeWith(u, c, t), Sl(e, r, t.isInline ? -1 : 1)) } } static findFrom(e, t, r = !1) {
    const i = e.parent.inlineContent ? new E(e) : un(e.node(0), e.parent, e.pos, e.index(), t, r); if (i)
      return i; for (let s = e.depth - 1; s >= 0; s--) {
      const o = t < 0 ? un(e.node(0), e.node(s), e.before(s + 1), e.index(s), t, r) : un(e.node(0), e.node(s), e.after(s + 1), e.index(s) + 1, t, r); if (o)
        return o
    } return null
  }

  static near(e, t = 1) { return this.findFrom(e, t) || this.findFrom(e, -t) || new q(e.node(0)) } static atStart(e) { return un(e, e, 0, 0, 1) || new q(e) } static atEnd(e) { return un(e, e, e.content.size, e.childCount, -1) || new q(e) } static fromJSON(e, t) {
    if (!t || !t.type)
      throw new RangeError('Invalid input for Selection.fromJSON'); const r = Ri[t.type]; if (!r)
      throw new RangeError(`No selection type ${t.type} defined`); return r.fromJSON(e, t)
  }

  static jsonID(e, t) {
    if (e in Ri)
      throw new RangeError(`Duplicate use of selection JSON ID ${e}`); return Ri[e] = t, t.prototype.jsonID = e, t
  }

  getBookmark() { return E.between(this.$anchor, this.$head).getBookmark() }
}; M.prototype.visible = !0; var zi = class {constructor(e, t) { this.$from = e, this.$to = t }}; let Cl = !1; function kl(n) { !Cl && !n.parent.inlineContent && (Cl = !0, console.warn(`TextSelection endpoint not pointing into a node with inline content (${n.parent.type.name})`)) } var E = class extends M {
  constructor(e, t = e) { kl(e), kl(t), super(e, t) } get $cursor() { return this.$anchor.pos == this.$head.pos ? this.$head : null }map(e, t) {
    const r = e.resolve(t.map(this.head)); if (!r.parent.inlineContent)
      return M.near(r); const i = e.resolve(t.map(this.anchor)); return new E(i.parent.inlineContent ? i : r, r)
  }

  replace(e, t = b.empty) { if (super.replace(e, t), t == b.empty) { const r = this.$from.marksAcross(this.$to); r && e.ensureMarks(r) } }eq(e) { return e instanceof E && e.anchor == this.anchor && e.head == this.head }getBookmark() { return new cn(this.anchor, this.head) }toJSON() { return { type: 'text', anchor: this.anchor, head: this.head } } static fromJSON(e, t) {
    if (typeof t.anchor != 'number' || typeof t.head != 'number')
      throw new RangeError('Invalid input for TextSelection.fromJSON'); return new E(e.resolve(t.anchor), e.resolve(t.head))
  }

  static create(e, t, r = t) { const i = e.resolve(t); return new this(i, r == t ? i : e.resolve(r)) } static between(e, t, r) {
    const i = e.pos - t.pos; if ((!r || i) && (r = i >= 0 ? 1 : -1), !t.parent.inlineContent) {
      const s = M.findFrom(t, r, !0) || M.findFrom(t, -r, !0); if (s)
        t = s.$head; else return M.near(t, r)
    } return e.parent.inlineContent || (i == 0 ? e = t : (e = (M.findFrom(e, -r, !0) || M.findFrom(e, r, !0)).$anchor, e.pos < t.pos != i < 0 && (e = t))), new E(e, t)
  }
}; M.jsonID('text', E); var cn = class {constructor(e, t) { this.anchor = e, this.head = t }map(e) { return new cn(e.map(this.anchor), e.map(this.head)) }resolve(e) { return E.between(e.resolve(this.anchor), e.resolve(this.head)) }}; var k = class extends M {
  constructor(e) { const t = e.nodeAfter; const r = e.node(0).resolve(e.pos + t.nodeSize); super(e, r), this.node = t }map(e, t) { const { deleted: r, pos: i } = t.mapResult(this.anchor); const s = e.resolve(i); return r ? M.near(s) : new k(s) }content() { return new b(y.from(this.node), 0, 0) }eq(e) { return e instanceof k && e.anchor == this.anchor }toJSON() { return { type: 'node', anchor: this.anchor } }getBookmark() { return new Vn(this.anchor) } static fromJSON(e, t) {
    if (typeof t.anchor != 'number')
      throw new RangeError('Invalid input for NodeSelection.fromJSON'); return new k(e.resolve(t.anchor))
  }

  static create(e, t) { return new k(e.resolve(t)) } static isSelectable(e) { return !e.isText && e.type.spec.selectable !== !1 }
}; k.prototype.visible = !1; M.jsonID('node', k); var Vn = class {constructor(e) { this.anchor = e }map(e) { const { deleted: t, pos: r } = e.mapResult(this.anchor); return t ? new cn(r, r) : new Vn(r) }resolve(e) { const t = e.resolve(this.anchor); const r = t.nodeAfter; return r && k.isSelectable(r) ? new k(t) : M.near(t) }}; var q = class extends M {
  constructor(e) { super(e.resolve(0), e.resolve(e.content.size)) }replace(e, t = b.empty) {
    if (t == b.empty) { e.delete(0, e.doc.content.size); const r = M.atStart(e.doc); r.eq(e.selection) || e.setSelection(r) }
    else { super.replace(e, t) }
  }

  toJSON() { return { type: 'all' } } static fromJSON(e) { return new q(e) }map(e) { return new q(e) }eq(e) { return e instanceof q }getBookmark() { return Od }
}; M.jsonID('all', q); var Od = { map() { return this }, resolve(n) { return new q(n) } }; function un(n, e, t, r, i, s = !1) {
  if (e.inlineContent)
    return E.create(n, t); for (let o = r - (i > 0 ? 0 : 1); i > 0 ? o < e.childCount : o >= 0; o += i) {
    const l = e.child(o); if (l.isAtom) {
      if (!s && k.isSelectable(l))
        return k.create(n, t - (i < 0 ? l.nodeSize : 0))
    }
    else {
      const a = un(n, l, t + i, i < 0 ? l.childCount : 0, i, s); if (a)
        return a
    }t += l.nodeSize * i
  } return null
} function Sl(n, e, t) {
  const r = n.steps.length - 1; if (r < e)
    return; const i = n.steps[r]; if (!(i instanceof j || i instanceof z))
    return; const s = n.mapping.maps[r]; let o; s.forEach((l, a, u, c) => { o == null && (o = c) }), n.setSelection(M.near(n.doc.resolve(o), t))
} const xl = 1; const Er = 2; const El = 4; const Vi = class extends ln {
  constructor(e) { super(e.doc), this.curSelectionFor = 0, this.updated = 0, this.meta = Object.create(null), this.time = Date.now(), this.curSelection = e.selection, this.storedMarks = e.storedMarks } get selection() { return this.curSelectionFor < this.steps.length && (this.curSelection = this.curSelection.map(this.doc, this.mapping.slice(this.curSelectionFor)), this.curSelectionFor = this.steps.length), this.curSelection }setSelection(e) {
    if (e.$from.doc != this.doc)
      throw new RangeError('Selection passed to setSelection must point at the current document'); return this.curSelection = e, this.curSelectionFor = this.steps.length, this.updated = (this.updated | xl) & ~Er, this.storedMarks = null, this
  }

  get selectionSet() { return (this.updated & xl) > 0 }setStoredMarks(e) { return this.storedMarks = e, this.updated |= Er, this }ensureMarks(e) { return w.sameSet(this.storedMarks || this.selection.$from.marks(), e) || this.setStoredMarks(e), this }addStoredMark(e) { return this.ensureMarks(e.addToSet(this.storedMarks || this.selection.$head.marks())) }removeStoredMark(e) { return this.ensureMarks(e.removeFromSet(this.storedMarks || this.selection.$head.marks())) } get storedMarksSet() { return (this.updated & Er) > 0 }addStep(e, t) { super.addStep(e, t), this.updated = this.updated & ~Er, this.storedMarks = null }setTime(e) { return this.time = e, this }replaceSelection(e) { return this.selection.replace(this, e), this }replaceSelectionWith(e, t = !0) { const r = this.selection; return t && (e = e.mark(this.storedMarks || (r.empty ? r.$from.marks() : r.$from.marksAcross(r.$to) || w.none))), r.replaceWith(this, e), this }deleteSelection() { return this.selection.replace(this), this }insertText(e, t, r) {
    const i = this.doc.type.schema; if (t == null)
      return e ? this.replaceSelectionWith(i.text(e), !0) : this.deleteSelection(); { if (r == null && (r = t), r = r ?? t, !e)
      return this.deleteRange(t, r); let s = this.storedMarks; if (!s) { const o = this.doc.resolve(t); s = r == t ? o.marks() : o.marksAcross(this.doc.resolve(r)) } return this.replaceRangeWith(t, r, i.text(e, s)), this.selection.empty || this.setSelection(M.near(this.selection.$to)), this }
  }

  setMeta(e, t) { return this.meta[typeof e == 'string' ? e : e.key] = t, this }getMeta(e) { return this.meta[typeof e == 'string' ? e : e.key] } get isGeneric() { for (const e in this.meta) return !1; return !0 }scrollIntoView() { return this.updated |= El, this } get scrolledIntoView() { return (this.updated & El) > 0 }
}; function Al(n, e) { return !e || !n ? n : n.bind(e) } const Rt = class {constructor(e, t, r) { this.name = e, this.init = Al(t.init, r), this.apply = Al(t.apply, r) }}; const Td = [new Rt('doc', { init(n) { return n.doc || n.schema.topNodeType.createAndFill() }, apply(n) { return n.doc } }), new Rt('selection', { init(n, e) { return n.selection || M.atStart(e.doc) }, apply(n) { return n.selection } }), new Rt('storedMarks', { init(n) { return n.storedMarks || null }, apply(n, e, t, r) { return r.selection.$cursor ? n.storedMarks : null } }), new Rt('scrollToSelection', { init() { return 0 }, apply(n, e) { return n.scrolledIntoView ? e + 1 : e } })]; const zn = class {
  constructor(e, t) {
    this.schema = e, this.plugins = [], this.pluginsByKey = Object.create(null), this.fields = Td.slice(), t && t.forEach((r) => {
      if (this.pluginsByKey[r.key])
        throw new RangeError(`Adding different instances of a keyed plugin (${r.key})`); this.plugins.push(r), this.pluginsByKey[r.key] = r, r.spec.state && this.fields.push(new Rt(r.key, r.spec.state, r))
    })
  }
}; var Xe = class {
  constructor(e) { this.config = e } get schema() { return this.config.schema } get plugins() { return this.config.plugins }apply(e) { return this.applyTransaction(e).state }filterTransaction(e, t = -1) {
    for (let r = 0; r < this.config.plugins.length; r++) {
      if (r != t) {
        const i = this.config.plugins[r]; if (i.spec.filterTransaction && !i.spec.filterTransaction.call(i, e, this))
          return !1
      }
    } return !0
  }

  applyTransaction(e) {
    if (!this.filterTransaction(e))
      return { state: this, transactions: [] }; const t = [e]; let r = this.applyInner(e); let i = null; for (;;) {
      let s = !1; for (let o = 0; o < this.config.plugins.length; o++) { const l = this.config.plugins[o]; if (l.spec.appendTransaction) { const a = i ? i[o].n : 0; const u = i ? i[o].state : this; const c = a < t.length && l.spec.appendTransaction.call(l, a ? t.slice(a) : t, u, r); if (c && r.filterTransaction(c, o)) { if (c.setMeta('appendedTransaction', e), !i) { i = []; for (let d = 0; d < this.config.plugins.length; d++)i.push(d < o ? { state: r, n: t.length } : { state: this, n: 0 }) }t.push(c), r = r.applyInner(c), s = !0 }i && (i[o] = { state: r, n: t.length }) } } if (!s)
        return { state: r, transactions: t }
    }
  }

  applyInner(e) {
    if (!e.before.eq(this.doc))
      throw new RangeError('Applying a mismatched transaction'); const t = new Xe(this.config); const r = this.config.fields; for (let i = 0; i < r.length; i++) { const s = r[i]; t[s.name] = s.apply(e, this[s.name], this, t) } return t
  }

  get tr() { return new Vi(this) } static create(e) { const t = new zn(e.doc ? e.doc.type.schema : e.schema, e.plugins); const r = new Xe(t); for (let i = 0; i < t.fields.length; i++)r[t.fields[i].name] = t.fields[i].init(e, r); return r }reconfigure(e) { const t = new zn(this.schema, e.plugins); const r = t.fields; const i = new Xe(t); for (let s = 0; s < r.length; s++) { const o = r[s].name; i[o] = this.hasOwnProperty(o) ? this[o] : r[s].init(e, i) } return i }toJSON(e) {
    const t = { doc: this.doc.toJSON(), selection: this.selection.toJSON() }; if (this.storedMarks && (t.storedMarks = this.storedMarks.map(r => r.toJSON())), e && typeof e == 'object') {
      for (const r in e) {
        if (r == 'doc' || r == 'selection')
          throw new RangeError('The JSON fields `doc` and `selection` are reserved'); const i = e[r]; const s = i.spec.state; s && s.toJSON && (t[r] = s.toJSON.call(i, this[i.key]))
      }
    } return t
  }

  static fromJSON(e, t, r) {
    if (!t)
      throw new RangeError('Invalid input for EditorState.fromJSON'); if (!e.schema)
      throw new RangeError('Required config field \'schema\' missing'); const i = new zn(e.schema, e.plugins); const s = new Xe(i); return i.fields.forEach((o) => {
      if (o.name == 'doc') { s.doc = he.fromJSON(e.schema, t.doc) }
      else if (o.name == 'selection') { s.selection = M.fromJSON(s.doc, t.selection) }
      else if (o.name == 'storedMarks') { t.storedMarks && (s.storedMarks = t.storedMarks.map(e.schema.markFromJSON)) }
      else {
        if (r)
          for (const l in r) { const a = r[l]; const u = a.spec.state; if (a.key == o.name && u && u.fromJSON && Object.prototype.hasOwnProperty.call(t, l)) { s[o.name] = u.fromJSON.call(a, e, t[l], s); return } }s[o.name] = o.init(e, s)
      }
    }), s
  }
}; function Ml(n, e, t) { for (const r in n) { let i = n[r]; i instanceof Function ? i = i.bind(e) : r == 'handleDOMEvents' && (i = Ml(i, e, {})), t[r] = i } return t } const L = class {constructor(e) { this.spec = e, this.props = {}, e.props && Ml(e.props, this, this.props), this.key = e.key ? e.key.key : Ol('plugin') }getState(e) { return e[this.key] }}; const Li = Object.create(null); function Ol(n) { return n in Li ? `${n}$${++Li[n]}` : (Li[n] = 0, `${n}$`) } const _ = class {constructor(e = 'key') { this.key = Ol(e) }get(e) { return e.config.pluginsByKey[this.key] }getState(e) { return e[this.key] }}; const gt = typeof navigator < 'u' ? navigator : null; const Tl = typeof document < 'u' ? document : null; const Dt = gt && gt.userAgent || ''; const _i = /Edge\/(\d+)/.exec(Dt); const ra = /MSIE \d/.exec(Dt); const Ji = /Trident\/(?:[7-9]|\d{2,})\..*rv:(\d+)/.exec(Dt); const Ce = !!(ra || Ji || _i); const mt = ra ? document.documentMode : Ji ? +Ji[1] : _i ? +_i[1] : 0; const je = !Ce && /gecko\/(\d+)/i.test(Dt); je && +(/Firefox\/(\d+)/.exec(Dt) || [0, 0])[1]; const Ui = !Ce && /Chrome\/(\d+)/.exec(Dt); const ue = !!Ui; const Nd = Ui ? +Ui[1] : 0; const pe = !Ce && !!gt && /Apple Computer/.test(gt.vendor); const gn = pe && (/Mobile\/\w+/.test(Dt) || !!gt && gt.maxTouchPoints > 2); const Te = gn || (gt ? /Mac/.test(gt.platform) : !1); const Ve = /Android \d/.test(Dt); const Fr = !!Tl && 'webkitFontSmoothing' in Tl.documentElement.style; const wd = Fr ? +(/\bAppleWebKit\/(\d+)/.exec(navigator.userAgent) || [0, 0])[1] : 0; const De = function (n) {
  for (let e = 0; ;e++) {
    if (n = n.previousSibling, !n)
      return e
  }
}; const fs = function (n) { const e = n.assignedSlot || n.parentNode; return e && e.nodeType == 11 ? e.host : e }; let Nl = null; const Ze = function (n, e, t) { const r = Nl || (Nl = document.createRange()); return r.setEnd(n, t ?? n.nodeValue.length), r.setStart(n, e || 0), r }; const jn = function (n, e, t, r) { return t && (wl(n, e, t, r, -1) || wl(n, e, t, r, 1)) }; const Fd = /^(img|br|input|textarea|hr)$/i; function wl(n, e, t, r, i) {
  for (;;) {
    if (n == t && e == r)
      return !0; if (e == (i < 0 ? 0 : He(n))) {
      const s = n.parentNode; if (!s || s.nodeType != 1 || Bd(n) || Fd.test(n.nodeName) || n.contentEditable == 'false')
        return !1; e = De(n) + (i < 0 ? 0 : 1), n = s
    }
    else if (n.nodeType == 1) {
      if (n = n.childNodes[e + (i < 0 ? -1 : 0)], n.contentEditable == 'false')
        return !1; e = i < 0 ? He(n) : 0
    }
    else { return !1 }
  }
} function He(n) { return n.nodeType == 3 ? n.nodeValue.length : n.childNodes.length } function vd(n, e, t) {
  for (let r = e == 0, i = e == He(n); r || i;) {
    if (n == t)
      return !0; const s = De(n); if (n = n.parentNode, !n)
      return !1; r = r && s == 0, i = i && s == He(n)
  }
} function Bd(n) { let e; for (let t = n; t && !(e = t.pmViewDesc); t = t.parentNode);return e && e.node && e.node.isBlock && (e.dom == n || e.contentDOM == n) } const hs = function (n) { let e = n.isCollapsed; return e && ue && n.rangeCount && !n.getRangeAt(0).collapsed && (e = !1), e }; function hn(n, e) { const t = document.createEvent('Event'); return t.initEvent('keydown', !0, !0), t.keyCode = n, t.key = t.code = e, t } function Id(n) { return { left: 0, right: n.documentElement.clientWidth, top: 0, bottom: n.documentElement.clientHeight } } function ht(n, e) { return typeof n == 'number' ? n : n[e] } function Pd(n) { const e = n.getBoundingClientRect(); const t = e.width / n.offsetWidth || 1; const r = e.height / n.offsetHeight || 1; return { left: e.left, right: e.left + n.clientWidth * t, top: e.top, bottom: e.top + n.clientHeight * r } } function Fl(n, e, t) {
  const r = n.someProp('scrollThreshold') || 0; const i = n.someProp('scrollMargin') || 5; const s = n.dom.ownerDocument; for (let o = t || n.dom; o; o = fs(o)) {
    if (o.nodeType != 1)
      continue; const l = o; const a = l == s.body; const u = a ? Id(s) : Pd(l); let c = 0; let d = 0; if (e.top < u.top + ht(r, 'top') ? d = -(u.top - e.top + ht(i, 'top')) : e.bottom > u.bottom - ht(r, 'bottom') && (d = e.bottom - u.bottom + ht(i, 'bottom')), e.left < u.left + ht(r, 'left') ? c = -(u.left - e.left + ht(i, 'left')) : e.right > u.right - ht(r, 'right') && (c = e.right - u.right + ht(i, 'right')), c || d)
      if (a) { s.defaultView.scrollBy(c, d) }
 else { const f = l.scrollLeft; const h = l.scrollTop; d && (l.scrollTop += d), c && (l.scrollLeft += c); const p = l.scrollLeft - f; const m = l.scrollTop - h; e = { left: e.left - p, top: e.top - m, right: e.right - p, bottom: e.bottom - m } }
    if (a)
      break
  }
} function Rd(n) {
  const e = n.dom.getBoundingClientRect(); const t = Math.max(0, e.top); let r; let i; for (let s = (e.left + e.right) / 2, o = t + 1; o < Math.min(innerHeight, e.bottom); o += 5) {
    const l = n.root.elementFromPoint(s, o); if (!l || l == n.dom || !n.dom.contains(l))
      continue; const a = l.getBoundingClientRect(); if (a.top >= t - 20) { r = l, i = a.top; break }
  } return { refDOM: r, refTop: i, stack: ia(n.dom) }
} function ia(n) { const e = []; const t = n.ownerDocument; for (let r = n; r && (e.push({ dom: r, top: r.scrollTop, left: r.scrollLeft }), n != t); r = fs(r));return e } function Ld({ refDOM: n, refTop: e, stack: t }) { const r = n ? n.getBoundingClientRect().top : 0; sa(t, r == 0 ? 0 : r - e) } function sa(n, e) { for (let t = 0; t < n.length; t++) { const { dom: r, top: i, left: s } = n[t]; r.scrollTop != i + e && (r.scrollTop = i + e), r.scrollLeft != s && (r.scrollLeft = s) } } let dn = null; function zd(n) {
  if (n.setActive)
    return n.setActive(); if (dn)
    return n.focus(dn); const e = ia(n); n.focus(dn == null ? { get preventScroll() { return dn = { preventScroll: !0 }, !0 } } : void 0), dn || (dn = !1, sa(e, 0))
} function oa(n, e) {
  let t; let r = 2e8; let i; let s = 0; let o = e.top; let l = e.top; for (let a = n.firstChild, u = 0; a; a = a.nextSibling, u++) {
    let c; if (a.nodeType == 1)
      c = a.getClientRects(); else if (a.nodeType == 3)
      c = Ze(a).getClientRects(); else continue; for (let d = 0; d < c.length; d++) { const f = c[d]; if (f.top <= o && f.bottom >= l) { o = Math.max(f.bottom, o), l = Math.min(f.top, l); const h = f.left > e.left ? f.left - e.left : f.right < e.left ? e.left - f.right : 0; if (h < r) { t = a, r = h, i = h && t.nodeType == 3 ? { left: f.right < e.left ? f.right : f.left, top: e.top } : e, a.nodeType == 1 && h && (s = u + (e.left >= (f.left + f.right) / 2 ? 1 : 0)); continue } }!t && (e.left >= f.right && e.top >= f.top || e.left >= f.left && e.top >= f.bottom) && (s = u + 1) }
  } return t && t.nodeType == 3 ? Vd(t, i) : !t || r && t.nodeType == 1 ? { node: n, offset: s } : oa(t, i)
} function Vd(n, e) {
  const t = n.nodeValue.length; const r = document.createRange(); for (let i = 0; i < t; i++) {
    r.setEnd(n, i + 1), r.setStart(n, i); const s = pt(r, 1); if (s.top != s.bottom && ps(e, s))
      return { node: n, offset: i + (e.left >= (s.left + s.right) / 2 ? 1 : 0) }
  } return { node: n, offset: 0 }
} function ps(n, e) { return n.left >= e.left - 1 && n.left <= e.right + 1 && n.top >= e.top - 1 && n.top <= e.bottom + 1 } function Hd(n, e) { const t = n.parentNode; return t && /^li$/i.test(t.nodeName) && e.left < n.getBoundingClientRect().left ? t : n } function $d(n, e, t) { const { node: r, offset: i } = oa(e, t); let s = -1; if (r.nodeType == 1 && !r.firstChild) { const o = r.getBoundingClientRect(); s = o.left != o.right && t.left > (o.left + o.right) / 2 ? 1 : -1 } return n.docView.posFromDOM(r, i, s) } function Kd(n, e, t, r) {
  let i = -1; for (let s = e; s != n.dom;) {
    const o = n.docView.nearestDesc(s, !0); if (!o)
      return null; if (o.node.isBlock && o.parent) {
      const l = o.dom.getBoundingClientRect(); if (l.left > r.left || l.top > r.top)
        i = o.posBefore; else if (l.right < r.left || l.bottom < r.top)
        i = o.posAfter; else break
    }s = o.dom.parentNode
  } return i > -1 ? i : n.docView.posFromDOM(e, t, 1)
} function la(n, e, t) {
  const r = n.childNodes.length; if (r && t.top < t.bottom) {
    for (let i = Math.max(0, Math.min(r - 1, Math.floor(r * (e.top - t.top) / (t.bottom - t.top)) - 2)), s = i; ;) {
      const o = n.childNodes[s]; if (o.nodeType == 1) {
        const l = o.getClientRects(); for (let a = 0; a < l.length; a++) {
          const u = l[a]; if (ps(e, u))
            return la(o, e, u)
        }
      } if ((s = (s + 1) % r) == i)
        break
    }
  } return n
} function jd(n, e) {
  const t = n.dom.ownerDocument; let r; let i = 0; if (t.caretPositionFromPoint) {
    try { const a = t.caretPositionFromPoint(e.left, e.top); a && ({ offsetNode: r, offset: i } = a) }
    catch {}
  } if (!r && t.caretRangeFromPoint) { const a = t.caretRangeFromPoint(e.left, e.top); a && ({ startContainer: r, startOffset: i } = a) } let s = (n.root.elementFromPoint ? n.root : t).elementFromPoint(e.left, e.top + 1); let o; if (!s || !n.dom.contains(s.nodeType != 1 ? s.parentNode : s)) {
    const a = n.dom.getBoundingClientRect(); if (!ps(e, a) || (s = la(n.dom, e, a), !s))
      return null
  } if (pe)
    for (let a = s; r && a; a = fs(a))a.draggable && (r = void 0); if (s = Hd(s, e), r) { if (je && r.nodeType == 1 && (i = Math.min(i, r.childNodes.length), i < r.childNodes.length)) { const a = r.childNodes[i]; let u; a.nodeName == 'IMG' && (u = a.getBoundingClientRect()).right <= e.left && u.bottom > e.top && i++ }r == n.dom && i == r.childNodes.length - 1 && r.lastChild.nodeType == 1 && e.top > r.lastChild.getBoundingClientRect().bottom ? o = n.state.doc.content.size : (i == 0 || r.nodeType != 1 || r.childNodes[i - 1].nodeName != 'BR') && (o = Kd(n, r, i, e)) }o == null && (o = $d(n, s, e)); const l = n.docView.nearestDesc(s, !0); return { pos: o, inside: l ? l.posAtStart - l.border : -1 }
} function pt(n, e) { const t = n.getClientRects(); return t.length ? t[e < 0 ? 0 : t.length - 1] : n.getBoundingClientRect() } const Wd = /[\u0590-\u05F4\u0600-\u06FF\u0700-\u08AC]/; function aa(n, e, t) {
  const { node: r, offset: i } = n.docView.domFromPos(e, t < 0 ? -1 : 1); const s = Fr || je; if (r.nodeType == 3) {
    if (s && (Wd.test(r.nodeValue) || (t < 0 ? !i : i == r.nodeValue.length))) {
      const o = pt(Ze(r, i, i), t); if (je && i && /\s/.test(r.nodeValue[i - 1]) && i < r.nodeValue.length) {
        const l = pt(Ze(r, i - 1, i - 1), -1); if (l.top == o.top) {
          const a = pt(Ze(r, i, i + 1), -1); if (a.top != o.top)
            return Hn(a, a.left < l.left)
        }
      } return o
    }
    else { let o = i; let l = i; let a = t < 0 ? 1 : -1; return t < 0 && !i ? (l++, a = -1) : t >= 0 && i == r.nodeValue.length ? (o--, a = 1) : t < 0 ? o-- : l++, Hn(pt(Ze(r, o, l), a), a < 0) }
  } if (!n.state.doc.resolve(e).parent.inlineContent) {
    if (i && (t < 0 || i == He(r))) {
      const o = r.childNodes[i - 1]; if (o.nodeType == 1)
        return Hi(o.getBoundingClientRect(), !1)
    } if (i < He(r)) {
      const o = r.childNodes[i]; if (o.nodeType == 1)
        return Hi(o.getBoundingClientRect(), !0)
    } return Hi(r.getBoundingClientRect(), t >= 0)
  } if (i && (t < 0 || i == He(r))) {
    const o = r.childNodes[i - 1]; const l = o.nodeType == 3 ? Ze(o, He(o) - (s ? 0 : 1)) : o.nodeType == 1 && (o.nodeName != 'BR' || !o.nextSibling) ? o : null; if (l)
      return Hn(pt(l, 1), !1)
  } if (i < He(r)) {
    let o = r.childNodes[i]; for (;o.pmViewDesc && o.pmViewDesc.ignoreForCoords;)o = o.nextSibling; const l = o ? o.nodeType == 3 ? Ze(o, 0, s ? 0 : 1) : o.nodeType == 1 ? o : null : null; if (l)
      return Hn(pt(l, -1), !0)
  } return Hn(pt(r.nodeType == 3 ? Ze(r) : r, -t), t >= 0)
} function Hn(n, e) {
  if (n.width == 0)
    return n; const t = e ? n.left : n.right; return { top: n.top, bottom: n.bottom, left: t, right: t }
} function Hi(n, e) {
  if (n.height == 0)
    return n; const t = e ? n.top : n.bottom; return { top: t, bottom: t, left: n.left, right: n.right }
} function ua(n, e, t) {
  const r = n.state; const i = n.root.activeElement; r != e && n.updateState(e), i != n.dom && n.focus(); try { return t() }
  finally { r != e && n.updateState(r), i != n.dom && i && i.focus() }
} function qd(n, e, t) {
  const r = e.selection; const i = t == 'up' ? r.$from : r.$to; return ua(n, e, () => {
    let { node: s } = n.docView.domFromPos(i.pos, t == 'up' ? -1 : 1); for (;;) {
      const l = n.docView.nearestDesc(s, !0); if (!l)
        break; if (l.node.isBlock) { s = l.dom; break }s = l.dom.parentNode
    } const o = aa(n, i.pos, 1); for (let l = s.firstChild; l; l = l.nextSibling) {
      let a; if (l.nodeType == 1)
        a = l.getClientRects(); else if (l.nodeType == 3)
        a = Ze(l, 0, l.nodeValue.length).getClientRects(); else continue; for (let u = 0; u < a.length; u++) {
        const c = a[u]; if (c.bottom > c.top + 1 && (t == 'up' ? o.top - c.top > (c.bottom - o.top) * 2 : c.bottom - o.bottom > (o.bottom - c.top) * 2))
          return !1
      }
    } return !0
  })
} const _d = /[\u0590-\u08AC]/; function Jd(n, e, t) {
  const { $head: r } = e.selection; if (!r.parent.isTextblock)
    return !1; const i = r.parentOffset; const s = !i; const o = i == r.parent.content.size; const l = n.domSelection(); return !_d.test(r.parent.textContent) || !l.modify ? t == 'left' || t == 'backward' ? s : o : ua(n, e, () => { const a = l.getRangeAt(0); const u = l.focusNode; const c = l.focusOffset; const d = l.caretBidiLevel; l.modify('move', t, 'character'); const h = !(r.depth ? n.docView.domAfterPos(r.before()) : n.dom).contains(l.focusNode.nodeType == 1 ? l.focusNode : l.focusNode.parentNode) || u == l.focusNode && c == l.focusOffset; return l.removeAllRanges(), l.addRange(a), d != null && (l.caretBidiLevel = d), h })
} let vl = null; let Bl = null; let Il = !1; function Ud(n, e, t) { return vl == e && Bl == t ? Il : (vl = e, Bl = t, Il = t == 'up' || t == 'down' ? qd(n, e, t) : Jd(n, e, t)) } const Be = 0; const Pl = 1; const pn = 2; const We = 3; const Kt = class {
  constructor(e, t, r, i) { this.parent = e, this.children = t, this.dom = r, this.contentDOM = i, this.dirty = Be, r.pmViewDesc = this }matchesWidget(e) { return !1 }matchesMark(e) { return !1 }matchesNode(e, t, r) { return !1 }matchesHack(e) { return !1 }parseRule() { return null }stopEvent(e) { return !1 } get size() { let e = 0; for (let t = 0; t < this.children.length; t++)e += this.children[t].size; return e } get border() { return 0 }destroy() { this.parent = void 0, this.dom.pmViewDesc == this && (this.dom.pmViewDesc = void 0); for (let e = 0; e < this.children.length; e++) this.children[e].destroy() }posBeforeChild(e) {
    for (let t = 0, r = this.posAtStart; ;t++) {
      const i = this.children[t]; if (i == e)
        return r; r += i.size
    }
  }

  get posBefore() { return this.parent.posBeforeChild(this) } get posAtStart() { return this.parent ? this.parent.posBeforeChild(this) + this.border : 0 } get posAfter() { return this.posBefore + this.size } get posAtEnd() { return this.posAtStart + this.size - 2 * this.border }localPosFromDOM(e, t, r) {
    if (this.contentDOM && this.contentDOM.contains(e.nodeType == 1 ? e : e.parentNode)) {
      if (r < 0) {
        let s, o; if (e == this.contentDOM) { s = e.childNodes[t - 1]} else { for (;e.parentNode != this.contentDOM;)e = e.parentNode; s = e.previousSibling } for (;s && !((o = s.pmViewDesc) && o.parent == this);)s = s.previousSibling; return s ? this.posBeforeChild(o) + o.size : this.posAtStart
      }
      else {
        let s, o; if (e == this.contentDOM) { s = e.childNodes[t]} else { for (;e.parentNode != this.contentDOM;)e = e.parentNode; s = e.nextSibling } for (;s && !((o = s.pmViewDesc) && o.parent == this);)s = s.nextSibling; return s ? this.posBeforeChild(o) : this.posAtEnd
      }
    } let i; if (e == this.dom && this.contentDOM) { i = t > De(this.contentDOM) }
    else if (this.contentDOM && this.contentDOM != this.dom && this.dom.contains(this.contentDOM)) { i = e.compareDocumentPosition(this.contentDOM) & 2 }
    else if (this.dom.firstChild) {
      if (t == 0) {
        for (let s = e; ;s = s.parentNode) {
          if (s == this.dom) { i = !1; break } if (s.previousSibling)
            break
        }
      } if (i == null && t == e.childNodes.length) {
        for (let s = e; ;s = s.parentNode) {
          if (s == this.dom) { i = !0; break } if (s.nextSibling)
            break
        }
      }
    } return i ?? r > 0 ? this.posAtEnd : this.posAtStart
  }

  nearestDesc(e, t = !1) {
    for (let r = !0, i = e; i; i = i.parentNode) {
      const s = this.getDesc(i); let o; if (s && (!t || s.node)) {
        if (r && (o = s.nodeDOM) && !(o.nodeType == 1 ? o.contains(e.nodeType == 1 ? e : e.parentNode) : o == e))
          r = !1; else return s
      }
    }
  }

  getDesc(e) {
    const t = e.pmViewDesc; for (let r = t; r; r = r.parent) {
      if (r == this)
        return t
    }
  }

  posFromDOM(e, t, r) {
    for (let i = e; i; i = i.parentNode) {
      const s = this.getDesc(i); if (s)
        return s.localPosFromDOM(e, t, r)
    } return -1
  }

  descAt(e) {
    for (let t = 0, r = 0; t < this.children.length; t++) {
      let i = this.children[t]; const s = r + i.size; if (r == e && s != r) { for (;!i.border && i.children.length;)i = i.children[0]; return i } if (e < s)
        return i.descAt(e - r - i.border); r = s
    }
  }

  domFromPos(e, t) {
    if (!this.contentDOM)
      return { node: this.dom, offset: 0 }; let r = 0; let i = 0; for (let s = 0; r < this.children.length; r++) { const o = this.children[r]; const l = s + o.size; if (l > e || o instanceof Mr) { i = e - s; break }s = l } if (i)
      return this.children[r].domFromPos(i - this.children[r].border, t); for (let s; r && !(s = this.children[r - 1]).size && s instanceof Ar && s.side >= 0; r--);if (t <= 0) { let s; let o = !0; for (;s = r ? this.children[r - 1] : null, !(!s || s.dom.parentNode == this.contentDOM); r--, o = !1);return s && t && o && !s.border && !s.domAtom ? s.domFromPos(s.size, t) : { node: this.contentDOM, offset: s ? De(s.dom) + 1 : 0 } }
    else { let s; let o = !0; for (;s = r < this.children.length ? this.children[r] : null, !(!s || s.dom.parentNode == this.contentDOM); r++, o = !1);return s && o && !s.border && !s.domAtom ? s.domFromPos(0, t) : { node: this.contentDOM, offset: s ? De(s.dom) : this.contentDOM.childNodes.length } }
  }

  parseRange(e, t, r = 0) {
    if (this.children.length == 0)
      return { node: this.contentDOM, from: e, to: t, fromOffset: 0, toOffset: this.contentDOM.childNodes.length }; let i = -1; let s = -1; for (let o = r, l = 0; ;l++) {
      const a = this.children[l]; const u = o + a.size; if (i == -1 && e <= u) {
        const c = o + a.border; if (e >= c && t <= u - a.border && a.node && a.contentDOM && this.contentDOM.contains(a.contentDOM))
          return a.parseRange(e, t, c); e = o; for (let d = l; d > 0; d--) { const f = this.children[d - 1]; if (f.size && f.dom.parentNode == this.contentDOM && !f.emptyChildAt(1)) { i = De(f.dom) + 1; break }e -= f.size }i == -1 && (i = 0)
      } if (i > -1 && (u > t || l == this.children.length - 1)) { t = u; for (let c = l + 1; c < this.children.length; c++) { const d = this.children[c]; if (d.size && d.dom.parentNode == this.contentDOM && !d.emptyChildAt(-1)) { s = De(d.dom); break }t += d.size }s == -1 && (s = this.contentDOM.childNodes.length); break }o = u
    } return { node: this.contentDOM, from: e, to: t, fromOffset: i, toOffset: s }
  }

  emptyChildAt(e) {
    if (this.border || !this.contentDOM || !this.children.length)
      return !1; const t = this.children[e < 0 ? 0 : this.children.length - 1]; return t.size == 0 || t.emptyChildAt(e)
  }

  domAfterPos(e) {
    const { node: t, offset: r } = this.domFromPos(e, 0); if (t.nodeType != 1 || r == t.childNodes.length)
      throw new RangeError(`No node after pos ${e}`); return t.childNodes[r]
  }

  setSelection(e, t, r, i = !1) {
    const s = Math.min(e, t); const o = Math.max(e, t); for (let f = 0, h = 0; f < this.children.length; f++) {
      const p = this.children[f]; const m = h + p.size; if (s > h && o < m)
        return p.setSelection(e - h - p.border, t - h - p.border, r, i); h = m
    } let l = this.domFromPos(e, e ? -1 : 1); let a = t == e ? l : this.domFromPos(t, t ? -1 : 1); const u = r.getSelection(); let c = !1; if ((je || pe) && e == t) {
      const { node: f, offset: h } = l; if (f.nodeType == 3) {
        if (c = !!(h && f.nodeValue[h - 1] == `
`), c && h == f.nodeValue.length) {
          for (let p = f, m; p; p = p.parentNode) {
            if (m = p.nextSibling) { m.nodeName == 'BR' && (l = a = { node: m.parentNode, offset: De(m) + 1 }); break } const g = p.pmViewDesc; if (g && g.node && g.node.isBlock)
              break
          }
        }
      }
      else { const p = f.childNodes[h - 1]; c = p && (p.nodeName == 'BR' || p.contentEditable == 'false') }
    } if (je && u.focusNode && u.focusNode != a.node && u.focusNode.nodeType == 1) { const f = u.focusNode.childNodes[u.focusOffset]; f && f.contentEditable == 'false' && (i = !0) } if (!(i || c && pe) && jn(l.node, l.offset, u.anchorNode, u.anchorOffset) && jn(a.node, a.offset, u.focusNode, u.focusOffset))
      return; let d = !1; if ((u.extend || e == t) && !c) {
      u.collapse(l.node, l.offset); try { e != t && u.extend(a.node, a.offset), d = !0 }
      catch (f) {
        if (!(f instanceof DOMException))
          throw f
      }
    } if (!d) { if (e > t) { const h = l; l = a, a = h } const f = document.createRange(); f.setEnd(a.node, a.offset), f.setStart(l.node, l.offset), u.removeAllRanges(), u.addRange(f) }
  }

  ignoreMutation(e) { return !this.contentDOM && e.type != 'selection' } get contentLost() { return this.contentDOM && this.contentDOM != this.dom && !this.dom.contains(this.contentDOM) }markDirty(e, t) {
    for (let r = 0, i = 0; i < this.children.length; i++) {
      const s = this.children[i]; const o = r + s.size; if (r == o ? e <= o && t >= r : e < o && t > r) {
        const l = r + s.border; const a = o - s.border; if (e >= l && t <= a) { this.dirty = e == r || t == o ? pn : Pl, e == l && t == a && (s.contentLost || s.dom.parentNode != this.contentDOM) ? s.dirty = We : s.markDirty(e - l, t - l); return }
        else { s.dirty = s.dom == s.contentDOM && s.dom.parentNode == this.contentDOM && !s.children.length ? pn : We }
      }r = o
    } this.dirty = pn
  }

  markParentsDirty() { let e = 1; for (let t = this.parent; t; t = t.parent, e++) { const r = e == 1 ? pn : Pl; t.dirty < r && (t.dirty = r) } } get domAtom() { return !1 } get ignoreForCoords() { return !1 }
}; var Ar = class extends Kt {
  constructor(e, t, r, i) {
    let s; let o = t.type.toDOM; if (typeof o == 'function' && (o = o(r, () => {
      if (!s)
        return i; if (s.parent)
        return s.parent.posBeforeChild(s)
    })), !t.type.spec.raw) { if (o.nodeType != 1) { const l = document.createElement('span'); l.appendChild(o), o = l }o.contentEditable = 'false', o.classList.add('ProseMirror-widget') } super(e, [], o, null), this.widget = t, this.widget = t, s = this
  }

  matchesWidget(e) { return this.dirty == Be && e.type.eq(this.widget.type) }parseRule() { return { ignore: !0 } }stopEvent(e) { const t = this.widget.spec.stopEvent; return t ? t(e) : !1 }ignoreMutation(e) { return e.type != 'selection' || this.widget.spec.ignoreSelection }destroy() { this.widget.type.destroy(this.dom), super.destroy() } get domAtom() { return !0 } get side() { return this.widget.type.side }
}; const Gi = class extends Kt {constructor(e, t, r, i) { super(e, [], t, null), this.textDOM = r, this.text = i } get size() { return this.text.length }localPosFromDOM(e, t) { return e != this.textDOM ? this.posAtStart + (t ? this.size : 0) : this.posAtStart + t }domFromPos(e) { return { node: this.textDOM, offset: e } }ignoreMutation(e) { return e.type === 'characterData' && e.target.nodeValue == e.oldValue }}; var et = class extends Kt {constructor(e, t, r, i) { super(e, [], r, i), this.mark = t } static create(e, t, r, i) { const s = i.nodeViews[t.type.name]; let o = s && s(t, i, r); return (!o || !o.dom) && (o = X.renderSpec(document, t.type.spec.toDOM(t, r))), new et(e, t, o.dom, o.contentDOM || o.dom) }parseRule() { return this.dirty & We || this.mark.type.spec.reparseInView ? null : { mark: this.mark.type.name, attrs: this.mark.attrs, contentElement: this.contentDOM || void 0 } }matchesMark(e) { return this.dirty != We && this.mark.eq(e) }markDirty(e, t) { if (super.markDirty(e, t), this.dirty != Be) { let r = this.parent; for (;!r.node;)r = r.parent; r.dirty < this.dirty && (r.dirty = this.dirty), this.dirty = Be } }slice(e, t, r) { const i = et.create(this.parent, this.mark, !0, r); let s = this.children; const o = this.size; t < o && (s = es(s, t, o, r)), e > 0 && (s = es(s, 0, e, r)); for (let l = 0; l < s.length; l++)s[l].parent = i; return i.children = s, i }}; var tt = class extends Kt {
  constructor(e, t, r, i, s, o, l, a, u) { super(e, [], s, o), this.node = t, this.outerDeco = r, this.innerDeco = i, this.nodeDOM = l, o && this.updateChildren(a, u) } static create(e, t, r, i, s, o) {
    const l = s.nodeViews[t.type.name]; let a; const u = l && l(t, s, () => {
      if (!a)
        return o; if (a.parent)
        return a.parent.posBeforeChild(a)
    }, r, i); let c = u && u.dom; let d = u && u.contentDOM; if (t.isText) {
      if (!c)
        c = document.createTextNode(t.text); else if (c.nodeType != 3)
        throw new RangeError('Text must be rendered as a DOM text node')
    }
    else { c || ({ dom: c, contentDOM: d } = X.renderSpec(document, t.type.spec.toDOM(t))) }!d && !t.isText && c.nodeName != 'BR' && (c.hasAttribute('contenteditable') || (c.contentEditable = 'false'), t.type.spec.draggable && (c.draggable = !0)); const f = c; return c = fa(c, r, t), u ? a = new Yi(e, t, r, i, c, d || null, f, u, s, o + 1) : t.isText ? new yn(e, t, r, i, c, f, s) : new tt(e, t, r, i, c, d || null, f, s, o + 1)
  }

  parseRule() {
    if (this.node.type.spec.reparseInView)
      return null; const e = { node: this.node.type.name, attrs: this.node.attrs }; if (this.node.type.whitespace == 'pre' && (e.preserveWhitespace = 'full'), !this.contentDOM) { e.getContent = () => this.node.content }
    else if (!this.contentLost) { e.contentElement = this.contentDOM }
    else { for (let t = this.children.length - 1; t >= 0; t--) { const r = this.children[t]; if (this.dom.contains(r.dom.parentNode)) { e.contentElement = r.dom.parentNode; break } }e.contentElement || (e.getContent = () => y.empty) } return e
  }

  matchesNode(e, t, r) { return this.dirty == Be && e.eq(this.node) && Xi(t, this.outerDeco) && r.eq(this.innerDeco) } get size() { return this.node.nodeSize } get border() { return this.node.isLeaf ? 0 : 1 }updateChildren(e, t) { const r = this.node.inlineContent; let i = t; const s = e.composing ? this.localCompositionInfo(e, t) : null; const o = s && s.pos > -1 ? s : null; const l = s && s.pos < 0; const a = new Zi(this, o && o.node); Xd(this.node, this.innerDeco, (u, c, d) => { u.spec.marks ? a.syncToMarks(u.spec.marks, r, e) : u.type.side >= 0 && !d && a.syncToMarks(c == this.node.childCount ? w.none : this.node.child(c).marks, r, e), a.placeWidget(u, e, i) }, (u, c, d, f) => { a.syncToMarks(u.marks, r, e); let h; a.findNodeMatch(u, c, d, f) || l && e.state.selection.from > i && e.state.selection.to < i + u.nodeSize && (h = a.findIndexWithChild(s.node)) > -1 && a.updateNodeAt(u, c, d, h, e) || a.updateNextNode(u, c, d, e, f) || a.addNode(u, c, d, e, i), i += u.nodeSize }), a.syncToMarks([], r, e), this.node.isTextblock && a.addTextblockHacks(), a.destroyRest(), (a.changed || this.dirty == pn) && (o && this.protectLocalComposition(e, o), ca(this.contentDOM, this.children, e), gn && Zd(this.dom)) }localCompositionInfo(e, t) {
    const { from: r, to: i } = e.state.selection; if (!(e.state.selection instanceof E) || r < t || i > t + this.node.content.size)
      return null; const s = e.domSelection(); const o = ef(s.focusNode, s.focusOffset); if (!o || !this.dom.contains(o.parentNode))
      return null; if (this.node.inlineContent) { const l = o.nodeValue; const a = tf(this.node.content, l, r - t, i - t); return a < 0 ? null : { node: o, pos: a, text: l } }
    else { return { node: o, pos: -1, text: '' } }
  }

  protectLocalComposition(e, { node: t, pos: r, text: i }) {
    if (this.getDesc(t))
      return; let s = t; for (;s.parentNode != this.contentDOM; s = s.parentNode) { for (;s.previousSibling;)s.parentNode.removeChild(s.previousSibling); for (;s.nextSibling;)s.parentNode.removeChild(s.nextSibling); s.pmViewDesc && (s.pmViewDesc = void 0) } const o = new Gi(this, s, t, i); e.input.compositionNodes.push(o), this.children = es(this.children, r, r + i.length, e, o)
  }

  update(e, t, r, i) { return this.dirty == We || !e.sameMarkup(this.node) ? !1 : (this.updateInner(e, t, r, i), !0) }updateInner(e, t, r, i) { this.updateOuterDeco(t), this.node = e, this.innerDeco = r, this.contentDOM && this.updateChildren(i, this.posAtStart), this.dirty = Be }updateOuterDeco(e) {
    if (Xi(e, this.outerDeco))
      return; const t = this.nodeDOM.nodeType != 1; const r = this.dom; this.dom = da(this.dom, this.nodeDOM, Qi(this.outerDeco, this.node, t), Qi(e, this.node, t)), this.dom != r && (r.pmViewDesc = void 0, this.dom.pmViewDesc = this), this.outerDeco = e
  }

  selectNode() { this.nodeDOM.nodeType == 1 && this.nodeDOM.classList.add('ProseMirror-selectednode'), (this.contentDOM || !this.node.type.spec.draggable) && (this.dom.draggable = !0) }deselectNode() { this.nodeDOM.nodeType == 1 && this.nodeDOM.classList.remove('ProseMirror-selectednode'), (this.contentDOM || !this.node.type.spec.draggable) && this.dom.removeAttribute('draggable') } get domAtom() { return this.node.isAtom }
}; function Rl(n, e, t, r, i) { return fa(r, e, n), new tt(void 0, n, e, t, r, r, r, i, 0) } var yn = class extends tt {
  constructor(e, t, r, i, s, o, l) { super(e, t, r, i, s, null, o, l, 0) }parseRule() { let e = this.nodeDOM.parentNode; for (;e && e != this.dom && !e.pmIsDeco;)e = e.parentNode; return { skip: e || !0 } }update(e, t, r, i) { return this.dirty == We || this.dirty != Be && !this.inParent() || !e.sameMarkup(this.node) ? !1 : (this.updateOuterDeco(t), (this.dirty != Be || e.text != this.node.text) && e.text != this.nodeDOM.nodeValue && (this.nodeDOM.nodeValue = e.text, i.trackWrites == this.nodeDOM && (i.trackWrites = null)), this.node = e, this.dirty = Be, !0) }inParent() {
    const e = this.parent.contentDOM; for (let t = this.nodeDOM; t; t = t.parentNode) {
      if (t == e)
        return !0
    } return !1
  }

  domFromPos(e) { return { node: this.nodeDOM, offset: e } }localPosFromDOM(e, t, r) { return e == this.nodeDOM ? this.posAtStart + Math.min(t, this.node.text.length) : super.localPosFromDOM(e, t, r) }ignoreMutation(e) { return e.type != 'characterData' && e.type != 'selection' }slice(e, t, r) { const i = this.node.cut(e, t); const s = document.createTextNode(i.text); return new yn(this.parent, i, this.outerDeco, this.innerDeco, s, s, r) }markDirty(e, t) { super.markDirty(e, t), this.dom != this.nodeDOM && (e == 0 || t == this.nodeDOM.nodeValue.length) && (this.dirty = We) } get domAtom() { return !1 }
}; var Mr = class extends Kt {parseRule() { return { ignore: !0 } }matchesHack(e) { return this.dirty == Be && this.dom.nodeName == e } get domAtom() { return !0 } get ignoreForCoords() { return this.dom.nodeName == 'IMG' }}; var Yi = class extends tt {
  constructor(e, t, r, i, s, o, l, a, u, c) { super(e, t, r, i, s, o, l, u, c), this.spec = a }update(e, t, r, i) {
    if (this.dirty == We)
      return !1; if (this.spec.update) { const s = this.spec.update(e, t, r); return s && this.updateInner(e, t, r, i), s }
    else { return !this.contentDOM && !e.isLeaf ? !1 : super.update(e, t, r, i) }
  }

  selectNode() { this.spec.selectNode ? this.spec.selectNode() : super.selectNode() }deselectNode() { this.spec.deselectNode ? this.spec.deselectNode() : super.deselectNode() }setSelection(e, t, r, i) { this.spec.setSelection ? this.spec.setSelection(e, t, r) : super.setSelection(e, t, r, i) }destroy() { this.spec.destroy && this.spec.destroy(), super.destroy() }stopEvent(e) { return this.spec.stopEvent ? this.spec.stopEvent(e) : !1 }ignoreMutation(e) { return this.spec.ignoreMutation ? this.spec.ignoreMutation(e) : super.ignoreMutation(e) }
}; function ca(n, e, t) {
  let r = n.firstChild; let i = !1; for (let s = 0; s < e.length; s++) {
    const o = e[s]; const l = o.dom; if (l.parentNode == n) { for (;l != r;)r = Ll(r), i = !0; r = r.nextSibling }
    else { i = !0, n.insertBefore(l, r) } if (o instanceof et) { const a = r ? r.previousSibling : n.lastChild; ca(o.contentDOM, o.children, t), r = a ? a.nextSibling : n.firstChild }
  } for (;r;)r = Ll(r), i = !0; i && t.trackWrites == n && (t.trackWrites = null)
} const $n = function (n) { n && (this.nodeName = n) }; $n.prototype = Object.create(null); const zt = [new $n()]; function Qi(n, e, t) {
  if (n.length == 0)
    return zt; let r = t ? zt[0] : new $n(); const i = [r]; for (let s = 0; s < n.length; s++) { const o = n[s].type.attrs; if (o) { o.nodeName && i.push(r = new $n(o.nodeName)); for (const l in o) { const a = o[l]; a != null && (t && i.length == 1 && i.push(r = new $n(e.isInline ? 'span' : 'div')), l == 'class' ? r.class = (r.class ? `${r.class} ` : '') + a : l == 'style' ? r.style = (r.style ? `${r.style};` : '') + a : l != 'nodeName' && (r[l] = a)) } } } return i
} function da(n, e, t, r) {
  if (t == zt && r == zt)
    return e; let i = e; for (let s = 0; s < r.length; s++) { const o = r[s]; let l = t[s]; if (s) { let a; l && l.nodeName == o.nodeName && i != n && (a = i.parentNode) && a.nodeName.toLowerCase() == o.nodeName || (a = document.createElement(o.nodeName), a.pmIsDeco = !0, a.appendChild(i), l = zt[0]), i = a }Gd(i, l || zt[0], o) } return i
} function Gd(n, e, t) { for (const r in e)r != 'class' && r != 'style' && r != 'nodeName' && !(r in t) && n.removeAttribute(r); for (const r in t)r != 'class' && r != 'style' && r != 'nodeName' && t[r] != e[r] && n.setAttribute(r, t[r]); if (e.class != t.class) { const r = e.class ? e.class.split(' ').filter(Boolean) : []; const i = t.class ? t.class.split(' ').filter(Boolean) : []; for (let s = 0; s < r.length; s++)!i.includes(r[s]) && n.classList.remove(r[s]); for (let s = 0; s < i.length; s++)!r.includes(i[s]) && n.classList.add(i[s]); n.classList.length == 0 && n.removeAttribute('class') } if (e.style != t.style) { if (e.style) { const r = /\s*([\w\-\xA1-\uFFFF]+)\s*:(?:"(?:\\.|[^"])*"|'(?:\\.|[^'])*'|\(.*?\)|[^;])*/g; let i; for (;i = r.exec(e.style);)n.style.removeProperty(i[1]) }t.style && (n.style.cssText += t.style) } } function fa(n, e, t) { return da(n, n, zt, Qi(e, t, n.nodeType != 1)) } function Xi(n, e) {
  if (n.length != e.length)
    return !1; for (let t = 0; t < n.length; t++) {
    if (!n[t].type.eq(e[t].type))
      return !1
  } return !0
} function Ll(n) { const e = n.nextSibling; return n.parentNode.removeChild(n), e } var Zi = class {
  constructor(e, t) { this.lock = t, this.index = 0, this.stack = [], this.changed = !1, this.top = e, this.preMatch = Yd(e.node.content, e) }destroyBetween(e, t) { if (e != t) { for (let r = e; r < t; r++) this.top.children[r].destroy(); this.top.children.splice(e, t - e), this.changed = !0 } }destroyRest() { this.destroyBetween(this.index, this.top.children.length) }syncToMarks(e, t, r) {
    let i = 0; let s = this.stack.length >> 1; const o = Math.min(s, e.length); for (;i < o && (i == s - 1 ? this.top : this.stack[i + 1 << 1]).matchesMark(e[i]) && e[i].type.spec.spanning !== !1;)i++; for (;i < s;) this.destroyRest(), this.top.dirty = Be, this.index = this.stack.pop(), this.top = this.stack.pop(), s--; for (;s < e.length;) {
      this.stack.push(this.top, this.index + 1); let l = -1; for (let a = this.index; a < Math.min(this.index + 3, this.top.children.length); a++) if (this.top.children[a].matchesMark(e[s])) { l = a; break } if (l > -1) { l > this.index && (this.changed = !0, this.destroyBetween(this.index, l)), this.top = this.top.children[this.index] }
      else { const a = et.create(this.top, e[s], t, r); this.top.children.splice(this.index, 0, a), this.top = a, this.changed = !0 } this.index = 0, s++
    }
  }

  findNodeMatch(e, t, r, i) {
    let s = -1; let o; if (i >= this.preMatch.index && (o = this.preMatch.matches[i - this.preMatch.index]).parent == this.top && o.matchesNode(e, t, r))
      s = this.top.children.indexOf(o, this.index); else for (let l = this.index, a = Math.min(this.top.children.length, l + 5); l < a; l++) { const u = this.top.children[l]; if (u.matchesNode(e, t, r) && !this.preMatch.matched.has(u)) { s = l; break } } return s < 0 ? !1 : (this.destroyBetween(this.index, s), this.index++, !0)
  }

  updateNodeAt(e, t, r, i, s) { const o = this.top.children[i]; return o.dirty == We && o.dom == o.contentDOM && (o.dirty = pn), o.update(e, t, r, s) ? (this.destroyBetween(this.index, i), this.index = i + 1, !0) : !1 }findIndexWithChild(e) {
    for (;;) {
      const t = e.parentNode; if (!t)
        return -1; if (t == this.top.contentDOM) {
        const r = e.pmViewDesc; if (r) {
          for (let i = this.index; i < this.top.children.length; i++) {
            if (this.top.children[i] == r)
              return i
          }
        } return -1
      }e = t
    }
  }

  updateNextNode(e, t, r, i, s) {
    for (let o = this.index; o < this.top.children.length; o++) {
      const l = this.top.children[o]; if (l instanceof tt) {
        const a = this.preMatch.matched.get(l); if (a != null && a != s)
          return !1; const u = l.dom; if (!(this.lock && (u == this.lock || u.nodeType == 1 && u.contains(this.lock.parentNode)) && !(e.isText && l.node && l.node.isText && l.nodeDOM.nodeValue == e.text && l.dirty != We && Xi(t, l.outerDeco))) && l.update(e, t, r, i))
          return this.destroyBetween(this.index, o), l.dom != u && (this.changed = !0), this.index++, !0; break
      }
    } return !1
  }

  addNode(e, t, r, i, s) { this.top.children.splice(this.index++, 0, tt.create(this.top, e, t, r, i, s)), this.changed = !0 }placeWidget(e, t, r) {
    const i = this.index < this.top.children.length ? this.top.children[this.index] : null; if (i && i.matchesWidget(e) && (e == i.widget || !i.widget.type.toDOM.parentNode)) { this.index++ }
    else { const s = new Ar(this.top, e, t, r); this.top.children.splice(this.index++, 0, s), this.changed = !0 }
  }

  addTextblockHacks() { let e = this.top.children[this.index - 1]; let t = this.top; for (;e instanceof et;)t = e, e = t.children[t.children.length - 1]; (!e || !(e instanceof yn) || /\n$/.test(e.node.text)) && ((pe || ue) && e && e.dom.contentEditable == 'false' && this.addHackNode('IMG', t), this.addHackNode('BR', this.top)) }addHackNode(e, t) {
    if (t == this.top && this.index < t.children.length && t.children[this.index].matchesHack(e)) { this.index++ }
    else { const r = document.createElement(e); e == 'IMG' && (r.className = 'ProseMirror-separator', r.alt = ''), e == 'BR' && (r.className = 'ProseMirror-trailingBreak'); const i = new Mr(this.top, [], r, null); t != this.top ? t.children.push(i) : t.children.splice(this.index++, 0, i), this.changed = !0 }
  }
}; function Yd(n, e) {
  let t = e; let r = t.children.length; let i = n.childCount; const s = new Map(); const o = []; e:for (;i > 0;) {
    let l; for (;;) {
      if (r) {
        const u = t.children[r - 1]; if (u instanceof et) { t = u, r = u.children.length }
        else { l = u, r--; break }
      }
      else {
        if (t == e)
          break e; r = t.parent.children.indexOf(t), t = t.parent
      }
    } const a = l.node; if (a) {
      if (a != n.child(i - 1))
        break; --i, s.set(l, i), o.push(l)
    }
  } return { index: i, matched: s, matches: o.reverse() }
} function Qd(n, e) { return n.type.side - e.type.side } function Xd(n, e, t, r) {
  const i = e.locals(n); let s = 0; if (i.length == 0) { for (let u = 0; u < n.childCount; u++) { const c = n.child(u); r(c, i, e.forChild(s, c), u), s += c.nodeSize } return } let o = 0; const l = []; let a = null; for (let u = 0; ;) {
    if (o < i.length && i[o].to == s) {
      const p = i[o++]; let m; for (;o < i.length && i[o].to == s;)(m || (m = [p])).push(i[o++]); if (m) { m.sort(Qd); for (let g = 0; g < m.length; g++)t(m[g], u, !!a) }
      else { t(p, u, !!a) }
    } let c, d; if (a)
      d = -1, c = a, a = null; else if (u < n.childCount)
      d = u, c = n.child(u++); else break; for (let p = 0; p < l.length; p++)l[p].to <= s && l.splice(p--, 1); for (;o < i.length && i[o].from <= s && i[o].to > s;)l.push(i[o++]); let f = s + c.nodeSize; if (c.isText) { let p = f; o < i.length && i[o].from < p && (p = i[o].from); for (let m = 0; m < l.length; m++)l[m].to < p && (p = l[m].to); p < f && (a = c.cut(p - s), c = c.cut(0, p - s), f = p, d = -1) } const h = c.isInline && !c.isLeaf ? l.filter(p => !p.inline) : l.slice(); r(c, h, e.forChild(s, c), d), s = f
  }
} function Zd(n) { if (n.nodeName == 'UL' || n.nodeName == 'OL') { const e = n.style.cssText; n.style.cssText = `${e}; list-style: square !important`, window.getComputedStyle(n).listStyle, n.style.cssText = e } } function ef(n, e) {
  for (;;) {
    if (n.nodeType == 3)
      return n; if (n.nodeType == 1 && e > 0) {
      if (n.childNodes.length > e && n.childNodes[e].nodeType == 3)
        return n.childNodes[e]; n = n.childNodes[e - 1], e = He(n)
    }
    else if (n.nodeType == 1 && e < n.childNodes.length) { n = n.childNodes[e], e = 0 }
    else { return null }
  }
} function tf(n, e, t, r) {
  for (let i = 0, s = 0; i < n.childCount && s <= r;) {
    const o = n.child(i++); const l = s; if (s += o.nodeSize, !o.isText)
      continue; let a = o.text; for (;i < n.childCount;) {
      const u = n.child(i++); if (s += u.nodeSize, !u.isText)
        break; a += u.text
    } if (s >= t) {
      const u = l < r ? a.lastIndexOf(e, r - l - 1) : -1; if (u >= 0 && u + e.length + l >= t)
        return l + u; if (t == r && a.length >= r + e.length - l && a.slice(r - l, r - l + e.length) == e)
        return r
    }
  } return -1
} function es(n, e, t, r, i) { const s = []; for (let o = 0, l = 0; o < n.length; o++) { const a = n[o]; const u = l; const c = l += a.size; u >= t || c <= e ? s.push(a) : (u < e && s.push(a.slice(0, e - u, r)), i && (s.push(i), i = void 0), c > t && s.push(a.slice(t - u, a.size, r))) } return s } function ha(n, e = null) {
  const t = n.domSelection(); const r = n.state.doc; if (!t.focusNode)
    return null; let i = n.docView.nearestDesc(t.focusNode); const s = i && i.size == 0; const o = n.docView.posFromDOM(t.focusNode, t.focusOffset, 1); if (o < 0)
    return null; const l = r.resolve(o); let a; let u; if (hs(t)) { for (a = l; i && !i.node;)i = i.parent; const c = i.node; if (i && c.isAtom && k.isSelectable(c) && i.parent && !(c.isInline && vd(t.focusNode, t.focusOffset, i.dom))) { const d = i.posBefore; u = new k(o == d ? l : r.resolve(d)) } }
  else {
    const c = n.docView.posFromDOM(t.anchorNode, t.anchorOffset, 1); if (c < 0)
      return null; a = r.resolve(c)
  } if (!u) { const c = e == 'pointer' || n.state.selection.head < l.pos && !s ? 1 : -1; u = ms(n, a, l, c) } return u
} function pa(n) { return n.editable ? n.hasFocus() : ga(n) && document.activeElement && document.activeElement.contains(n.dom) } function yt(n, e = !1) {
  const t = n.state.selection; if (ma(n, t), !!pa(n)) {
    if (!e && n.input.mouseDown && n.input.mouseDown.allowDefault && ue) { const r = n.domSelection(); const i = n.domObserver.currentSelection; if (r.anchorNode && i.anchorNode && jn(r.anchorNode, r.anchorOffset, i.anchorNode, i.anchorOffset)) { n.input.mouseDown.delayedSelectionSync = !0, n.domObserver.setCurSelection(); return } } if (n.domObserver.disconnectSelection(), n.cursorWrapper) { rf(n) }
    else { const { anchor: r, head: i } = t; let s; let o; zl && !(t instanceof E) && (t.$from.parent.inlineContent || (s = Vl(n, t.from)), !t.empty && !t.$from.parent.inlineContent && (o = Vl(n, t.to))), n.docView.setSelection(r, i, n.root, e), zl && (s && Hl(s), o && Hl(o)), t.visible ? n.dom.classList.remove('ProseMirror-hideselection') : (n.dom.classList.add('ProseMirror-hideselection'), 'onselectionchange' in document && nf(n)) }n.domObserver.setCurSelection(), n.domObserver.connectSelection()
  }
} var zl = pe || ue && Nd < 63; function Vl(n, e) {
  const { node: t, offset: r } = n.docView.domFromPos(e, 0); const i = r < t.childNodes.length ? t.childNodes[r] : null; const s = r ? t.childNodes[r - 1] : null; if (pe && i && i.contentEditable == 'false')
    return $i(i); if ((!i || i.contentEditable == 'false') && (!s || s.contentEditable == 'false')) {
    if (i)
      return $i(i); if (s)
      return $i(s)
  }
} function $i(n) { return n.contentEditable = 'true', pe && n.draggable && (n.draggable = !1, n.wasDraggable = !0), n } function Hl(n) { n.contentEditable = 'false', n.wasDraggable && (n.draggable = !0, n.wasDraggable = null) } function nf(n) { const e = n.dom.ownerDocument; e.removeEventListener('selectionchange', n.input.hideSelectionGuard); const t = n.domSelection(); const r = t.anchorNode; const i = t.anchorOffset; e.addEventListener('selectionchange', n.input.hideSelectionGuard = () => { (t.anchorNode != r || t.anchorOffset != i) && (e.removeEventListener('selectionchange', n.input.hideSelectionGuard), setTimeout(() => { (!pa(n) || n.state.selection.visible) && n.dom.classList.remove('ProseMirror-hideselection') }, 20)) }) } function rf(n) { const e = n.domSelection(); const t = document.createRange(); const r = n.cursorWrapper.dom; const i = r.nodeName == 'IMG'; i ? t.setEnd(r.parentNode, De(r) + 1) : t.setEnd(r, 0), t.collapse(!1), e.removeAllRanges(), e.addRange(t), !i && !n.state.selection.visible && Ce && mt <= 11 && (r.disabled = !0, r.disabled = !1) } function ma(n, e) {
  if (e instanceof k) { const t = n.docView.descAt(e.from); t != n.lastSelectedViewDesc && ($l(n), t && t.selectNode(), n.lastSelectedViewDesc = t) }
  else { $l(n) }
} function $l(n) { n.lastSelectedViewDesc && (n.lastSelectedViewDesc.parent && n.lastSelectedViewDesc.deselectNode(), n.lastSelectedViewDesc = void 0) } function ms(n, e, t, r) { return n.someProp('createSelectionBetween', i => i(n, e, t)) || E.between(e, t, r) } function Kl(n) { return n.editable && n.root.activeElement != n.dom ? !1 : ga(n) } function ga(n) {
  const e = n.domSelection(); if (!e.anchorNode)
    return !1; try { return n.dom.contains(e.anchorNode.nodeType == 3 ? e.anchorNode.parentNode : e.anchorNode) && (n.editable || n.dom.contains(e.focusNode.nodeType == 3 ? e.focusNode.parentNode : e.focusNode)) }
  catch { return !1 }
} function sf(n) { const e = n.docView.domFromPos(n.state.selection.anchor, 0); const t = n.domSelection(); return jn(e.node, e.offset, t.anchorNode, t.anchorOffset) } function ts(n, e) { const { $anchor: t, $head: r } = n.selection; const i = e > 0 ? t.max(r) : t.min(r); const s = i.parent.inlineContent ? i.depth ? n.doc.resolve(e > 0 ? i.after() : i.before()) : null : i; return s && M.findFrom(s, e) } function Lt(n, e) { return n.dispatch(n.state.tr.setSelection(e).scrollIntoView()), !0 } function jl(n, e, t) {
  const r = n.state.selection; if (r instanceof E) {
    if (!r.empty || t.includes('s'))
      return !1; if (n.endOfTextblock(e > 0 ? 'right' : 'left')) { const i = ts(n.state, e); return i && i instanceof k ? Lt(n, i) : !1 }
    else if (!(Te && t.includes('m'))) {
      const i = r.$head; const s = i.textOffset ? null : e < 0 ? i.nodeBefore : i.nodeAfter; let o; if (!s || s.isText)
        return !1; const l = e < 0 ? i.pos - s.nodeSize : i.pos; return s.isAtom || (o = n.docView.descAt(l)) && !o.contentDOM ? k.isSelectable(s) ? Lt(n, new k(e < 0 ? n.state.doc.resolve(i.pos - s.nodeSize) : i)) : Fr ? Lt(n, new E(n.state.doc.resolve(e < 0 ? l : l + s.nodeSize))) : !1 : !1
    }
  }
  else {
    if (r instanceof k && r.node.isInline)
      return Lt(n, new E(e > 0 ? r.$to : r.$from)); { const i = ts(n.state, e); return i ? Lt(n, i) : !1 }
  }
} function Or(n) { return n.nodeType == 3 ? n.nodeValue.length : n.childNodes.length } function Kn(n) { const e = n.pmViewDesc; return e && e.size == 0 && (n.nextSibling || n.nodeName != 'BR') } function Ki(n) {
  const e = n.domSelection(); let t = e.focusNode; let r = e.focusOffset; if (!t)
    return; let i; let s; let o = !1; for (je && t.nodeType == 1 && r < Or(t) && Kn(t.childNodes[r]) && (o = !0); ;) {
    if (r > 0) {
      if (t.nodeType != 1)
        break; { const l = t.childNodes[r - 1]; if (Kn(l))
        i = t, s = --r; else if (l.nodeType == 3)
        t = l, r = t.nodeValue.length; else break }
    }
    else {
      if (ya(t))
        break; { let l = t.previousSibling; for (;l && Kn(l);)i = t.parentNode, s = De(l), l = l.previousSibling; if (l) { t = l, r = Or(t) }
      else {
        if (t = t.parentNode, t == n.dom)
          break; r = 0
      } }
    }
  }o ? ns(n, e, t, r) : i && ns(n, e, i, s)
} function ji(n) {
  const e = n.domSelection(); let t = e.focusNode; let r = e.focusOffset; if (!t)
    return; let i = Or(t); let s; let o; for (;;) {
    if (r < i) {
      if (t.nodeType != 1)
        break; const l = t.childNodes[r]; if (Kn(l))
        s = t, o = ++r; else break
    }
    else {
      if (ya(t))
        break; { let l = t.nextSibling; for (;l && Kn(l);)s = l.parentNode, o = De(l) + 1, l = l.nextSibling; if (l) { t = l, r = 0, i = Or(t) }
      else {
        if (t = t.parentNode, t == n.dom)
          break; r = i = 0
      } }
    }
  }s && ns(n, e, s, o)
} function ya(n) { const e = n.pmViewDesc; return e && e.node && e.node.isBlock } function ns(n, e, t, r) {
  if (hs(e)) { const s = document.createRange(); s.setEnd(t, r), s.setStart(t, r), e.removeAllRanges(), e.addRange(s) }
  else { e.extend && e.extend(t, r) }n.domObserver.setCurSelection(); const { state: i } = n; setTimeout(() => { n.state == i && yt(n) }, 50)
} function Wl(n, e, t) {
  const r = n.state.selection; if (r instanceof E && !r.empty || t.includes('s') || Te && t.includes('m'))
    return !1; const { $from: i, $to: s } = r; if (!i.parent.inlineContent || n.endOfTextblock(e < 0 ? 'up' : 'down')) {
    const o = ts(n.state, e); if (o && o instanceof k)
      return Lt(n, o)
  } if (!i.parent.inlineContent) { const o = e < 0 ? i : s; const l = r instanceof q ? M.near(o, e) : M.findFrom(o, e); return l ? Lt(n, l) : !1 } return !1
} function ql(n, e) {
  if (!(n.state.selection instanceof E))
    return !0; const { $head: t, $anchor: r, empty: i } = n.state.selection; if (!t.sameParent(r))
    return !0; if (!i)
    return !1; if (n.endOfTextblock(e > 0 ? 'forward' : 'backward'))
    return !0; const s = !t.textOffset && (e < 0 ? t.nodeBefore : t.nodeAfter); if (s && !s.isText) { const o = n.state.tr; return e < 0 ? o.delete(t.pos - s.nodeSize, t.pos) : o.delete(t.pos, t.pos + s.nodeSize), n.dispatch(o), !0 } return !1
} function _l(n, e, t) { n.domObserver.stop(), e.contentEditable = t, n.domObserver.start() } function of(n) {
  if (!pe || n.state.selection.$head.parentOffset > 0)
    return !1; const { focusNode: e, focusOffset: t } = n.domSelection(); if (e && e.nodeType == 1 && t == 0 && e.firstChild && e.firstChild.contentEditable == 'false') { const r = e.firstChild; _l(n, r, 'true'), setTimeout(() => _l(n, r, 'false'), 20) } return !1
} function lf(n) { let e = ''; return n.ctrlKey && (e += 'c'), n.metaKey && (e += 'm'), n.altKey && (e += 'a'), n.shiftKey && (e += 's'), e } function af(n, e) { const t = e.keyCode; const r = lf(e); return t == 8 || Te && t == 72 && r == 'c' ? ql(n, -1) || Ki(n) : t == 46 || Te && t == 68 && r == 'c' ? ql(n, 1) || ji(n) : t == 13 || t == 27 ? !0 : t == 37 || Te && t == 66 && r == 'c' ? jl(n, -1, r) || Ki(n) : t == 39 || Te && t == 70 && r == 'c' ? jl(n, 1, r) || ji(n) : t == 38 || Te && t == 80 && r == 'c' ? Wl(n, -1, r) || Ki(n) : t == 40 || Te && t == 78 && r == 'c' ? of(n) || Wl(n, 1, r) || ji(n) : r == (Te ? 'm' : 'c') && (t == 66 || t == 73 || t == 89 || t == 90) } function Da(n, e) {
  const t = []; let { content: r, openStart: i, openEnd: s } = e; for (;i > 1 && s > 1 && r.childCount == 1 && r.firstChild.childCount == 1;) { i--, s--; const h = r.firstChild; t.push(h.type.name, h.attrs != h.type.defaultAttrs ? h.attrs : null), r = h.content } const o = n.someProp('clipboardSerializer') || X.fromSchema(n.state.schema); const l = Ea(); const a = l.createElement('div'); a.appendChild(o.serializeFragment(r, { document: l })); let u = a.firstChild; let c; let d = 0; for (;u && u.nodeType == 1 && (c = xa[u.nodeName.toLowerCase()]);) { for (let h = c.length - 1; h >= 0; h--) { const p = l.createElement(c[h]); for (;a.firstChild;)p.appendChild(a.firstChild); a.appendChild(p), d++ }u = a.firstChild }u && u.nodeType == 1 && u.setAttribute('data-pm-slice', `${i} ${s}${d ? ` -${d}` : ''} ${JSON.stringify(t)}`); const f = n.someProp('clipboardTextSerializer', h => h(e)) || e.content.textBetween(0, e.content.size, `

`); return { dom: a, text: f }
} function ba(n, e, t, r, i) {
  const s = i.parent.type.spec.code; let o; let l; if (!t && !e)
    return null; const a = e && (r || s || !t); if (a) {
    if (n.someProp('transformPastedText', (f) => { e = f(e, s || r) }), s) {
      return e
        ? new b(y.from(n.state.schema.text(e.replace(/\r\n?/g, `
`))), 0, 0)
        : b.empty
    } const d = n.someProp('clipboardTextParser', f => f(e, i, r)); if (d) { l = d }
    else { const f = i.marks(); const { schema: h } = n.state; const p = X.fromSchema(h); o = document.createElement('div'), e.split(/(?:\r\n?|\n)+/).forEach((m) => { const g = o.appendChild(document.createElement('p')); m && g.appendChild(p.serializeNode(h.text(m, f))) }) }
  }
  else { n.someProp('transformPastedHTML', (d) => { t = d(t) }), o = df(t), Fr && ff(o) } const u = o && o.querySelector('[data-pm-slice]'); const c = u && /^(\d+) (\d+)(?: -(\d+))? (.*)/.exec(u.getAttribute('data-pm-slice') || ''); if (c && c[3])
    for (let d = +c[3]; d > 0 && o.firstChild; d--)o = o.firstChild; if (l || (l = (n.someProp('clipboardParser') || n.someProp('domParser') || Ae.fromSchema(n.state.schema)).parseSlice(o, { preserveWhitespace: !!(a || c), context: i, ruleFromNode(f) { return f.nodeName == 'BR' && !f.nextSibling && f.parentNode && !uf.test(f.parentNode.nodeName) ? { ignore: !0 } : null } })), c) { l = hf(Jl(l, +c[1], +c[2]), c[4]) }
  else if (l = b.maxOpen(cf(l.content, i), !0), l.openStart || l.openEnd) { let d = 0; let f = 0; for (let h = l.content.firstChild; d < l.openStart && !h.type.spec.isolating; d++, h = h.firstChild);for (let h = l.content.lastChild; f < l.openEnd && !h.type.spec.isolating; f++, h = h.lastChild);l = Jl(l, d, f) } return n.someProp('transformPasted', (d) => { l = d(l) }), l
} var uf = /^(a|abbr|acronym|b|cite|code|del|em|i|ins|kbd|label|output|q|ruby|s|samp|span|strong|sub|sup|time|u|tt|var)$/i; function cf(n, e) {
  if (n.childCount < 2)
    return n; for (let t = e.depth; t >= 0; t--) {
    let i = e.node(t).contentMatchAt(e.index(t)); let s; let o = []; if (n.forEach((l) => {
      if (!o)
        return; const a = i.findWrapping(l.type); let u; if (!a)
        return o = null; if (u = o.length && s.length && ka(a, s, l, o[o.length - 1], 0)) { o[o.length - 1] = u }
      else { o.length && (o[o.length - 1] = Sa(o[o.length - 1], s.length)); const c = Ca(l, a); o.push(c), i = i.matchType(c.type), s = a }
    }), o)
      return y.from(o)
  } return n
} function Ca(n, e, t = 0) { for (let r = e.length - 1; r >= t; r--)n = e[r].create(null, y.from(n)); return n } function ka(n, e, t, r, i) {
  if (i < n.length && i < e.length && n[i] == e[i]) {
    const s = ka(n, e, t, r.lastChild, i + 1); if (s)
      return r.copy(r.content.replaceChild(r.childCount - 1, s)); if (r.contentMatchAt(r.childCount).matchType(i == n.length - 1 ? t.type : n[i + 1]))
      return r.copy(r.content.append(y.from(Ca(t, n, i + 1))))
  }
} function Sa(n, e) {
  if (e == 0)
    return n; const t = n.content.replaceChild(n.childCount - 1, Sa(n.lastChild, e - 1)); const r = n.contentMatchAt(n.childCount).fillBefore(y.empty, !0); return n.copy(t.append(r))
} function rs(n, e, t, r, i, s) { const o = e < 0 ? n.firstChild : n.lastChild; let l = o.content; return i < r - 1 && (l = rs(l, e, t, r, i + 1, s)), i >= t && (l = e < 0 ? o.contentMatchAt(0).fillBefore(l, n.childCount > 1 || s <= i).append(l) : l.append(o.contentMatchAt(o.childCount).fillBefore(y.empty, !0))), n.replaceChild(e < 0 ? 0 : n.childCount - 1, o.copy(l)) } function Jl(n, e, t) { return e < n.openStart && (n = new b(rs(n.content, -1, e, n.openStart, 0, n.openEnd), e, n.openEnd)), t < n.openEnd && (n = new b(rs(n.content, 1, t, n.openEnd, 0, 0), n.openStart, t)), n } var xa = { thead: ['table'], tbody: ['table'], tfoot: ['table'], caption: ['table'], colgroup: ['table'], col: ['table', 'colgroup'], tr: ['table', 'tbody'], td: ['table', 'tbody', 'tr'], th: ['table', 'tbody', 'tr'] }; let Ul = null; function Ea() { return Ul || (Ul = document.implementation.createHTMLDocument('title')) } function df(n) {
  const e = /^(\s*<meta [^>]*>)*/.exec(n); e && (n = n.slice(e[0].length)); let t = Ea().createElement('div'); const r = /<([a-z][^>\s]+)/i.exec(n); let i; if ((i = r && xa[r[1].toLowerCase()]) && (n = i.map(s => `<${s}>`).join('') + n + i.map(s => `</${s}>`).reverse().join('')), t.innerHTML = n, i)
    for (let s = 0; s < i.length; s++)t = t.querySelector(i[s]) || t; return t
} function ff(n) { const e = n.querySelectorAll(ue ? 'span:not([class]):not([style])' : 'span.Apple-converted-space'); for (let t = 0; t < e.length; t++) { const r = e[t]; r.childNodes.length == 1 && r.textContent == '\xA0' && r.parentNode && r.parentNode.replaceChild(n.ownerDocument.createTextNode(' '), r) } } function hf(n, e) {
  if (!n.size)
    return n; const t = n.content.firstChild.type.schema; let r; try { r = JSON.parse(e) }
  catch { return n } let { content: i, openStart: s, openEnd: o } = n; for (let l = r.length - 2; l >= 0; l -= 2) {
    const a = t.nodes[r[l]]; if (!a || a.hasRequiredAttrs())
      break; i = y.from(a.create(r[l + 1], i)), s++, o++
  } return new b(i, s, o)
} const me = {}; const ce = {}; const is = class {constructor() { this.shiftKey = !1, this.mouseDown = null, this.lastKeyCode = null, this.lastKeyCodeTime = 0, this.lastClick = { time: 0, x: 0, y: 0, type: '' }, this.lastSelectionOrigin = null, this.lastSelectionTime = 0, this.lastIOSEnter = 0, this.lastIOSEnterFallbackTimeout = -1, this.lastAndroidDelete = 0, this.composing = !1, this.composingTimeout = -1, this.compositionNodes = [], this.compositionEndedAt = -2e8, this.domChangeCount = 0, this.eventHandlers = Object.create(null), this.hideSelectionGuard = null }}; function pf(n) { for (const e in me) { const t = me[e]; n.dom.addEventListener(e, n.input.eventHandlers[e] = (r) => { gf(n, r) && !gs(n, r) && (n.editable || !(r.type in ce)) && t(n, r) }) }pe && n.dom.addEventListener('input', () => null), ss(n) } function Vt(n, e) { n.input.lastSelectionOrigin = e, n.input.lastSelectionTime = Date.now() } function mf(n) { n.domObserver.stop(); for (const e in n.input.eventHandlers)n.dom.removeEventListener(e, n.input.eventHandlers[e]); clearTimeout(n.input.composingTimeout), clearTimeout(n.input.lastIOSEnterFallbackTimeout) } function ss(n) { n.someProp('handleDOMEvents', (e) => { for (const t in e)n.input.eventHandlers[t] || n.dom.addEventListener(t, n.input.eventHandlers[t] = r => gs(n, r)) }) } function gs(n, e) { return n.someProp('handleDOMEvents', (t) => { const r = t[e.type]; return r ? r(n, e) || e.defaultPrevented : !1 }) } function gf(n, e) {
  if (!e.bubbles)
    return !0; if (e.defaultPrevented)
    return !1; for (let t = e.target; t != n.dom; t = t.parentNode) {
    if (!t || t.nodeType == 11 || t.pmViewDesc && t.pmViewDesc.stopEvent(e))
      return !1
  } return !0
} function yf(n, e) { !gs(n, e) && me[e.type] && (n.editable || !(e.type in ce)) && me[e.type](n, e) }ce.keydown = (n, e) => {
  const t = e; if (n.input.shiftKey = t.keyCode == 16 || t.shiftKey, !Ma(n, t) && (n.input.lastKeyCode = t.keyCode, n.input.lastKeyCodeTime = Date.now(), !(Ve && ue && t.keyCode == 13))) {
    if (t.keyCode != 229 && n.domObserver.forceFlush(), gn && t.keyCode == 13 && !t.ctrlKey && !t.altKey && !t.metaKey) { const r = Date.now(); n.input.lastIOSEnter = r, n.input.lastIOSEnterFallbackTimeout = setTimeout(() => { n.input.lastIOSEnter == r && (n.someProp('handleKeyDown', i => i(n, hn(13, 'Enter'))), n.input.lastIOSEnter = 0) }, 200) }
    else { n.someProp('handleKeyDown', r => r(n, t)) || af(n, t) ? t.preventDefault() : Vt(n, 'key') }
  }
}; ce.keyup = (n, e) => { e.keyCode == 16 && (n.input.shiftKey = !1) }; ce.keypress = (n, e) => {
  const t = e; if (Ma(n, t) || !t.charCode || t.ctrlKey && !t.altKey || Te && t.metaKey)
    return; if (n.someProp('handleKeyPress', i => i(n, t))) { t.preventDefault(); return } const r = n.state.selection; if (!(r instanceof E) || !r.$from.sameParent(r.$to)) { const i = String.fromCharCode(t.charCode); n.someProp('handleTextInput', s => s(n, r.$from.pos, r.$to.pos, i)) || n.dispatch(n.state.tr.insertText(i).scrollIntoView()), t.preventDefault() }
}; function vr(n) { return { left: n.clientX, top: n.clientY } } function Df(n, e) { const t = e.x - n.clientX; const r = e.y - n.clientY; return t * t + r * r < 100 } function ys(n, e, t, r, i) {
  if (r == -1)
    return !1; const s = n.state.doc.resolve(r); for (let o = s.depth + 1; o > 0; o--) {
    if (n.someProp(e, l => o > s.depth ? l(n, t, s.nodeAfter, s.before(o), i, !0) : l(n, t, s.node(o), s.before(o), i, !1)))
      return !0
  } return !1
} function mn(n, e, t) { n.focused || n.focus(); const r = n.state.tr.setSelection(e); t == 'pointer' && r.setMeta('pointer', !0), n.dispatch(r) } function bf(n, e) {
  if (e == -1)
    return !1; const t = n.state.doc.resolve(e); const r = t.nodeAfter; return r && r.isAtom && k.isSelectable(r) ? (mn(n, new k(t), 'pointer'), !0) : !1
} function Cf(n, e) {
  if (e == -1)
    return !1; const t = n.state.selection; let r; let i; t instanceof k && (r = t.node); const s = n.state.doc.resolve(e); for (let o = s.depth + 1; o > 0; o--) { const l = o > s.depth ? s.nodeAfter : s.node(o); if (k.isSelectable(l)) { r && t.$from.depth > 0 && o >= t.$from.depth && s.before(t.$from.depth + 1) == t.$from.pos ? i = s.before(t.$from.depth) : i = s.before(o); break } } return i != null ? (mn(n, k.create(n.state.doc, i), 'pointer'), !0) : !1
} function kf(n, e, t, r, i) { return ys(n, 'handleClickOn', e, t, r) || n.someProp('handleClick', s => s(n, e, r)) || (i ? Cf(n, t) : bf(n, t)) } function Sf(n, e, t, r) { return ys(n, 'handleDoubleClickOn', e, t, r) || n.someProp('handleDoubleClick', i => i(n, e, r)) } function xf(n, e, t, r) { return ys(n, 'handleTripleClickOn', e, t, r) || n.someProp('handleTripleClick', i => i(n, e, r)) || Ef(n, t, r) } function Ef(n, e, t) {
  if (t.button != 0)
    return !1; const r = n.state.doc; if (e == -1)
    return r.inlineContent ? (mn(n, E.create(r, 0, r.content.size), 'pointer'), !0) : !1; const i = r.resolve(e); for (let s = i.depth + 1; s > 0; s--) {
    const o = s > i.depth ? i.nodeAfter : i.node(s); const l = i.before(s); if (o.inlineContent)
      mn(n, E.create(r, l + 1, l + 1 + o.content.size), 'pointer'); else if (k.isSelectable(o))
      mn(n, k.create(r, l), 'pointer'); else continue; return !0
  }
} function Ds(n) { return Tr(n) } const Aa = Te ? 'metaKey' : 'ctrlKey'; me.mousedown = (n, e) => { const t = e; n.input.shiftKey = t.shiftKey; const r = Ds(n); const i = Date.now(); let s = 'singleClick'; i - n.input.lastClick.time < 500 && Df(t, n.input.lastClick) && !t[Aa] && (n.input.lastClick.type == 'singleClick' ? s = 'doubleClick' : n.input.lastClick.type == 'doubleClick' && (s = 'tripleClick')), n.input.lastClick = { time: i, x: t.clientX, y: t.clientY, type: s }; const o = n.posAtCoords(vr(t)); !o || (s == 'singleClick' ? (n.input.mouseDown && n.input.mouseDown.done(), n.input.mouseDown = new ls(n, o, t, !!r)) : (s == 'doubleClick' ? Sf : xf)(n, o.pos, o.inside, t) ? t.preventDefault() : Vt(n, 'pointer')) }; var ls = class {
  constructor(e, t, r, i) {
    this.view = e, this.pos = t, this.event = r, this.flushed = i, this.delayedSelectionSync = !1, this.mightDrag = null, this.startDoc = e.state.doc, this.selectNode = !!r[Aa], this.allowDefault = r.shiftKey; let s, o; if (t.inside > -1) { s = e.state.doc.nodeAt(t.inside), o = t.inside }
    else { const c = e.state.doc.resolve(t.pos); s = c.parent, o = c.depth ? c.before() : 0 } const l = i ? null : r.target; const a = l ? e.docView.nearestDesc(l, !0) : null; this.target = a ? a.dom : null; const { selection: u } = e.state; (r.button == 0 && s.type.spec.draggable && s.type.spec.selectable !== !1 || u instanceof k && u.from <= o && u.to > o) && (this.mightDrag = { node: s, pos: o, addAttr: !!(this.target && !this.target.draggable), setUneditable: !!(this.target && je && !this.target.hasAttribute('contentEditable')) }), this.target && this.mightDrag && (this.mightDrag.addAttr || this.mightDrag.setUneditable) && (this.view.domObserver.stop(), this.mightDrag.addAttr && (this.target.draggable = !0), this.mightDrag.setUneditable && setTimeout(() => { this.view.input.mouseDown == this && this.target.setAttribute('contentEditable', 'false') }, 20), this.view.domObserver.start()), e.root.addEventListener('mouseup', this.up = this.up.bind(this)), e.root.addEventListener('mousemove', this.move = this.move.bind(this)), Vt(e, 'pointer')
  }

  done() { this.view.root.removeEventListener('mouseup', this.up), this.view.root.removeEventListener('mousemove', this.move), this.mightDrag && this.target && (this.view.domObserver.stop(), this.mightDrag.addAttr && this.target.removeAttribute('draggable'), this.mightDrag.setUneditable && this.target.removeAttribute('contentEditable'), this.view.domObserver.start()), this.delayedSelectionSync && setTimeout(() => yt(this.view)), this.view.input.mouseDown = null }up(e) {
    if (this.done(), !this.view.dom.contains(e.target))
      return; let t = this.pos; this.view.state.doc != this.startDoc && (t = this.view.posAtCoords(vr(e))), this.allowDefault || !t ? Vt(this.view, 'pointer') : kf(this.view, t.pos, t.inside, e, this.selectNode) ? e.preventDefault() : e.button == 0 && (this.flushed || pe && this.mightDrag && !this.mightDrag.node.isAtom || ue && !(this.view.state.selection instanceof E) && Math.min(Math.abs(t.pos - this.view.state.selection.from), Math.abs(t.pos - this.view.state.selection.to)) <= 2) ? (mn(this.view, M.near(this.view.state.doc.resolve(t.pos)), 'pointer'), e.preventDefault()) : Vt(this.view, 'pointer')
  }

  move(e) { !this.allowDefault && (Math.abs(this.event.x - e.clientX) > 4 || Math.abs(this.event.y - e.clientY) > 4) && (this.allowDefault = !0), Vt(this.view, 'pointer'), e.buttons == 0 && this.done() }
}; me.touchdown = (n) => { Ds(n), Vt(n, 'pointer') }; me.contextmenu = n => Ds(n); function Ma(n, e) { return n.composing ? !0 : pe && Math.abs(e.timeStamp - n.input.compositionEndedAt) < 500 ? (n.input.compositionEndedAt = -2e8, !0) : !1 } const Af = Ve ? 5e3 : -1; ce.compositionstart = ce.compositionupdate = (n) => {
  if (!n.composing) {
    n.domObserver.flush(); const { state: e } = n; const t = e.selection.$from; if (e.selection.empty && (e.storedMarks || !t.textOffset && t.parentOffset && t.nodeBefore.marks.some(r => r.type.spec.inclusive === !1))) { n.markCursor = n.state.storedMarks || t.marks(), Tr(n, !0), n.markCursor = null }
    else if (Tr(n), je && e.selection.empty && t.parentOffset && !t.textOffset && t.nodeBefore.marks.length) {
      const r = n.domSelection(); for (let i = r.focusNode, s = r.focusOffset; i && i.nodeType == 1 && s != 0;) {
        const o = s < 0 ? i.lastChild : i.childNodes[s - 1]; if (!o)
          break; if (o.nodeType == 3) { r.collapse(o, o.nodeValue.length); break }
        else { i = o, s = -1 }
      }
    }n.input.composing = !0
  }Oa(n, Af)
}; ce.compositionend = (n, e) => { n.composing && (n.input.composing = !1, n.input.compositionEndedAt = e.timeStamp, Oa(n, 20)) }; function Oa(n, e) { clearTimeout(n.input.composingTimeout), e > -1 && (n.input.composingTimeout = setTimeout(() => Tr(n), e)) } function Ta(n) { for (n.composing && (n.input.composing = !1, n.input.compositionEndedAt = Mf()); n.input.compositionNodes.length > 0;)n.input.compositionNodes.pop().markParentsDirty() } function Mf() { const n = document.createEvent('Event'); return n.initEvent('event', !0, !0), n.timeStamp } function Tr(n, e = !1) { if (!(Ve && n.domObserver.flushingSoon >= 0)) { if (n.domObserver.forceFlush(), Ta(n), e || n.docView && n.docView.dirty) { const t = ha(n); return t && !t.eq(n.state.selection) ? n.dispatch(n.state.tr.setSelection(t)) : n.updateState(n.state), !0 } return !1 } } function Of(n, e) {
  if (!n.dom.parentNode)
    return; const t = n.dom.parentNode.appendChild(document.createElement('div')); t.appendChild(e), t.style.cssText = 'position: fixed; left: -10000px; top: 10px'; const r = getSelection(); const i = document.createRange(); i.selectNodeContents(e), n.dom.blur(), r.removeAllRanges(), r.addRange(i), setTimeout(() => { t.parentNode && t.parentNode.removeChild(t), n.focus() }, 50)
} const Dn = Ce && mt < 15 || gn && wd < 604; me.copy = ce.cut = (n, e) => {
  const t = e; const r = n.state.selection; const i = t.type == 'cut'; if (r.empty)
    return; const s = Dn ? null : t.clipboardData; const o = r.content(); const { dom: l, text: a } = Da(n, o); s ? (t.preventDefault(), s.clearData(), s.setData('text/html', l.innerHTML), s.setData('text/plain', a)) : Of(n, l), i && n.dispatch(n.state.tr.deleteSelection().scrollIntoView().setMeta('uiEvent', 'cut'))
}; function Tf(n) { return n.openStart == 0 && n.openEnd == 0 && n.content.childCount == 1 ? n.content.firstChild : null } function Nf(n, e) {
  if (!n.dom.parentNode)
    return; const t = n.input.shiftKey || n.state.selection.$from.parent.type.spec.code; const r = n.dom.parentNode.appendChild(document.createElement(t ? 'textarea' : 'div')); t || (r.contentEditable = 'true'), r.style.cssText = 'position: fixed; left: -10000px; top: 10px', r.focus(), setTimeout(() => { n.focus(), r.parentNode && r.parentNode.removeChild(r), t ? as(n, r.value, null, e) : as(n, r.textContent, r.innerHTML, e) }, 50)
} function as(n, e, t, r) {
  const i = ba(n, e, t, n.input.shiftKey, n.state.selection.$from); if (n.someProp('handlePaste', l => l(n, r, i || b.empty)))
    return !0; if (!i)
    return !1; const s = Tf(i); const o = s ? n.state.tr.replaceSelectionWith(s, n.input.shiftKey) : n.state.tr.replaceSelection(i); return n.dispatch(o.scrollIntoView().setMeta('paste', !0).setMeta('uiEvent', 'paste')), !0
}ce.paste = (n, e) => {
  const t = e; if (n.composing && !Ve)
    return; const r = Dn ? null : t.clipboardData; r && as(n, r.getData('text/plain'), r.getData('text/html'), t) ? t.preventDefault() : Nf(n, t)
}; const us = class {constructor(e, t) { this.slice = e, this.move = t }}; const Na = Te ? 'altKey' : 'ctrlKey'; me.dragstart = (n, e) => {
  const t = e; const r = n.input.mouseDown; if (r && r.done(), !t.dataTransfer)
    return; const i = n.state.selection; const s = i.empty ? null : n.posAtCoords(vr(t)); if (!(s && s.pos >= i.from && s.pos <= (i instanceof k ? i.to - 1 : i.to))) {
    if (r && r.mightDrag) { n.dispatch(n.state.tr.setSelection(k.create(n.state.doc, r.mightDrag.pos))) }
    else if (t.target && t.target.nodeType == 1) { const u = n.docView.nearestDesc(t.target, !0); u && u.node.type.spec.draggable && u != n.docView && n.dispatch(n.state.tr.setSelection(k.create(n.state.doc, u.posBefore))) }
  }
  const o = n.state.selection.content(); const { dom: l, text: a } = Da(n, o); t.dataTransfer.clearData(), t.dataTransfer.setData(Dn ? 'Text' : 'text/html', l.innerHTML), t.dataTransfer.effectAllowed = 'copyMove', Dn || t.dataTransfer.setData('text/plain', a), n.dragging = new us(o, !t[Na])
}; me.dragend = (n) => { const e = n.dragging; window.setTimeout(() => { n.dragging == e && (n.dragging = null) }, 50) }; ce.dragover = ce.dragenter = (n, e) => e.preventDefault(); ce.drop = (n, e) => {
  const t = e; const r = n.dragging; if (n.dragging = null, !t.dataTransfer)
    return; const i = n.posAtCoords(vr(t)); if (!i)
    return; const s = n.state.doc.resolve(i.pos); if (!s)
    return; let o = r && r.slice; o ? n.someProp('transformPasted', (p) => { o = p(o) }) : o = ba(n, t.dataTransfer.getData(Dn ? 'Text' : 'text/plain'), Dn ? null : t.dataTransfer.getData('text/html'), !1, s); const l = !!(r && !t[Na]); if (n.someProp('handleDrop', p => p(n, t, o || b.empty, l))) { t.preventDefault(); return } if (!o)
    return; t.preventDefault(); let a = o ? ml(n.state.doc, s.pos, o) : s.pos; a == null && (a = s.pos); const u = n.state.tr; l && u.deleteSelection(); const c = u.mapping.map(a); const d = o.openStart == 0 && o.openEnd == 0 && o.content.childCount == 1; const f = u.doc; if (d ? u.replaceRangeWith(c, c, o.content.firstChild) : u.replaceRange(c, c, o), u.doc.eq(f))
    return; const h = u.doc.resolve(c); if (d && k.isSelectable(o.content.firstChild) && h.nodeAfter && h.nodeAfter.sameMarkup(o.content.firstChild)) { u.setSelection(new k(h)) }
  else { let p = u.mapping.map(a); u.mapping.maps[u.mapping.maps.length - 1].forEach((m, g, D, S) => p = S), u.setSelection(ms(n, h, u.doc.resolve(p))) }n.focus(), n.dispatch(u.setMeta('uiEvent', 'drop'))
}; me.focus = (n) => { n.focused || (n.domObserver.stop(), n.dom.classList.add('ProseMirror-focused'), n.domObserver.start(), n.focused = !0, setTimeout(() => { n.docView && n.hasFocus() && !n.domObserver.currentSelection.eq(n.domSelection()) && yt(n) }, 20)) }; me.blur = (n, e) => { const t = e; n.focused && (n.domObserver.stop(), n.dom.classList.remove('ProseMirror-focused'), n.domObserver.start(), t.relatedTarget && n.dom.contains(t.relatedTarget) && n.domObserver.currentSelection.clear(), n.focused = !1) }; me.beforeinput = (n, e) => {
  if (ue && Ve && e.inputType == 'deleteContentBackward') {
    n.domObserver.flushSoon(); const { domChangeCount: r } = n.input; setTimeout(() => {
      if (n.input.domChangeCount != r || (n.dom.blur(), n.focus(), n.someProp('handleKeyDown', s => s(n, hn(8, 'Backspace')))))
        return; const { $cursor: i } = n.state.selection; i && i.pos > 0 && n.dispatch(n.state.tr.delete(i.pos - 1, i.pos).scrollIntoView())
    }, 50)
  }
}; for (const n in ce)me[n] = ce[n]; function Wn(n, e) {
  if (n == e)
    return !0; for (const t in n) {
    if (n[t] !== e[t])
      return !1
  } for (const t in e) {
    if (!(t in n))
      return !1
  } return !0
} var qn = class {constructor(e, t) { this.toDOM = e, this.spec = t || Ht, this.side = this.spec.side || 0 }map(e, t, r, i) { const { pos: s, deleted: o } = e.mapResult(t.from + i, this.side < 0 ? -1 : 1); return o ? null : new be(s - r, s - r, this) }valid() { return !0 }eq(e) { return this == e || e instanceof qn && (this.spec.key && this.spec.key == e.spec.key || this.toDOM == e.toDOM && Wn(this.spec, e.spec)) }destroy(e) { this.spec.destroy && this.spec.destroy(e) }}; var Ke = class {constructor(e, t) { this.attrs = e, this.spec = t || Ht }map(e, t, r, i) { const s = e.map(t.from + i, this.spec.inclusiveStart ? -1 : 1) - r; const o = e.map(t.to + i, this.spec.inclusiveEnd ? 1 : -1) - r; return s >= o ? null : new be(s, o, this) }valid(e, t) { return t.from < t.to }eq(e) { return this == e || e instanceof Ke && Wn(this.attrs, e.attrs) && Wn(this.spec, e.spec) } static is(e) { return e.type instanceof Ke }destroy() {}}; var _n = class {
  constructor(e, t) { this.attrs = e, this.spec = t || Ht }map(e, t, r, i) {
    const s = e.mapResult(t.from + i, 1); if (s.deleted)
      return null; const o = e.mapResult(t.to + i, -1); return o.deleted || o.pos <= s.pos ? null : new be(s.pos - r, o.pos - r, this)
  }

  valid(e, t) { const { index: r, offset: i } = e.content.findIndex(t.from); let s; return i == t.from && !(s = e.child(r)).isText && i + s.nodeSize == t.to }eq(e) { return this == e || e instanceof _n && Wn(this.attrs, e.attrs) && Wn(this.spec, e.spec) }destroy() {}
}; var be = class {constructor(e, t, r) { this.from = e, this.to = t, this.type = r }copy(e, t) { return new be(e, t, this.type) }eq(e, t = 0) { return this.type.eq(e.type) && this.from + t == e.from && this.to + t == e.to }map(e, t, r) { return this.type.map(e, this, t, r) } static widget(e, t, r) { return new be(e, e, new qn(t, r)) } static inline(e, t, r, i) { return new be(e, t, new Ke(r, i)) } static node(e, t, r, i) { return new be(e, t, new _n(r, i)) } get spec() { return this.type.spec } get inline() { return this.type instanceof Ke }}; const fn = []; var Ht = {}; var U = class {
  constructor(e, t) { this.local = e.length ? e : fn, this.children = t.length ? t : fn } static create(e, t) { return t.length ? Nr(t, e, 0, Ht) : re }find(e, t, r) { const i = []; return this.findInner(e ?? 0, t ?? 1e9, i, 0, r), i }findInner(e, t, r, i, s) { for (let o = 0; o < this.local.length; o++) { const l = this.local[o]; l.from <= t && l.to >= e && (!s || s(l.spec)) && r.push(l.copy(l.from + i, l.to + i)) } for (let o = 0; o < this.children.length; o += 3) if (this.children[o] < t && this.children[o + 1] > e) { const l = this.children[o] + 1; this.children[o + 2].findInner(e - l, t - l, r, i + l, s) } }map(e, t, r) { return this == re || e.maps.length == 0 ? this : this.mapInner(e, t, 0, 0, r || Ht) }mapInner(e, t, r, i, s) { let o; for (let l = 0; l < this.local.length; l++) { const a = this.local[l].map(e, r, i); a && a.type.valid(t, a) ? (o || (o = [])).push(a) : s.onRemove && s.onRemove(this.local[l].spec) } return this.children.length ? wf(this.children, o || [], e, t, r, i, s) : o ? new U(o.sort($t), fn) : re }add(e, t) { return t.length ? this == re ? U.create(e, t) : this.addInner(e, t, 0) : this }addInner(e, t, r) { let i; let s = 0; e.forEach((l, a) => { const u = a + r; let c; if (c = Fa(t, l, u)) { for (i || (i = this.children.slice()); s < i.length && i[s] < a;)s += 3; i[s] == a ? i[s + 2] = i[s + 2].addInner(l, c, u + 1) : i.splice(s, 0, a, a + l.nodeSize, Nr(c, l, u + 1, Ht)), s += 3 } }); const o = wa(s ? va(t) : t, -r); for (let l = 0; l < o.length; l++)o[l].type.valid(e, o[l]) || o.splice(l--, 1); return new U(o.length ? this.local.concat(o).sort($t) : this.local, i || this.children) }remove(e) { return e.length == 0 || this == re ? this : this.removeInner(e, 0) }removeInner(e, t) {
    let r = this.children; let i = this.local; for (let s = 0; s < r.length; s += 3) {
      let o; const l = r[s] + t; const a = r[s + 1] + t; for (let c = 0, d; c < e.length; c++)(d = e[c]) && d.from > l && d.to < a && (e[c] = null, (o || (o = [])).push(d)); if (!o)
        continue; r == this.children && (r = this.children.slice()); const u = r[s + 2].removeInner(o, l + 1); u != re ? r[s + 2] = u : (r.splice(s, 3), s -= 3)
    } if (i.length) {
      for (let s = 0, o; s < e.length; s++) {
        if (o = e[s])
          for (let l = 0; l < i.length; l++)i[l].eq(o, t) && (i == this.local && (i = this.local.slice()), i.splice(l--, 1))
      }
    } return r == this.children && i == this.local ? this : i.length || r.length ? new U(i, r) : re
  }

  forChild(e, t) {
    if (this == re)
      return this; if (t.isLeaf)
      return U.empty; let r, i; for (let l = 0; l < this.children.length; l += 3) if (this.children[l] >= e) { this.children[l] == e && (r = this.children[l + 2]); break } const s = e + 1; const o = s + t.content.size; for (let l = 0; l < this.local.length; l++) { const a = this.local[l]; if (a.from < o && a.to > s && a.type instanceof Ke) { const u = Math.max(s, a.from) - s; const c = Math.min(o, a.to) - s; u < c && (i || (i = [])).push(a.copy(u, c)) } } if (i) { const l = new U(i.sort($t), fn); return r ? new $e([l, r]) : l } return r || re
  }

  eq(e) {
    if (this == e)
      return !0; if (!(e instanceof U) || this.local.length != e.local.length || this.children.length != e.children.length)
      return !1; for (let t = 0; t < this.local.length; t++) {
      if (!this.local[t].eq(e.local[t]))
        return !1
    } for (let t = 0; t < this.children.length; t += 3) {
      if (this.children[t] != e.children[t] || this.children[t + 1] != e.children[t + 1] || !this.children[t + 2].eq(e.children[t + 2]))
        return !1
    } return !0
  }

  locals(e) { return bs(this.localsInner(e)) }localsInner(e) {
    if (this == re)
      return fn; if (e.inlineContent || !this.local.some(Ke.is))
      return this.local; const t = []; for (let r = 0; r < this.local.length; r++) this.local[r].type instanceof Ke || t.push(this.local[r]); return t
  }
}; U.empty = new U([], []); U.removeOverlap = bs; var re = U.empty; var $e = class {
  constructor(e) { this.members = e }map(e, t) { const r = this.members.map(i => i.map(e, t, Ht)); return $e.from(r) }forChild(e, t) {
    if (t.isLeaf)
      return U.empty; let r = []; for (let i = 0; i < this.members.length; i++) { const s = this.members[i].forChild(e, t); s != re && (s instanceof $e ? r = r.concat(s.members) : r.push(s)) } return $e.from(r)
  }

  eq(e) {
    if (!(e instanceof $e) || e.members.length != this.members.length)
      return !1; for (let t = 0; t < this.members.length; t++) {
      if (!this.members[t].eq(e.members[t]))
        return !1
    } return !0
  }

  locals(e) {
    let t; let r = !0; for (let i = 0; i < this.members.length; i++) {
      const s = this.members[i].localsInner(e); if (s.length)
        if (!t) { t = s }
 else { r && (t = t.slice(), r = !1); for (let o = 0; o < s.length; o++)t.push(s[o]) }
    } return t ? bs(r ? t : t.sort($t)) : fn
  }

  static from(e) { switch (e.length) { case 0:return re; case 1:return e[0]; default:return new $e(e) } }
}; function wf(n, e, t, r, i, s, o) {
  const l = n.slice(); const a = (c, d, f, h) => {
    for (let p = 0; p < l.length; p += 3) {
      const m = l[p + 1]; let g; if (m < 0 || c > m + s)
        continue; const D = l[p] + s; d >= D ? l[p + 1] = c <= D ? -2 : -1 : f >= i && (g = h - f - (d - c)) && (l[p] += g, l[p + 1] += g)
    }
  }; for (let c = 0; c < t.maps.length; c++)t.maps[c].forEach(a); let u = !1; for (let c = 0; c < l.length; c += 3) {
    if (l[c + 1] < 0) {
      if (l[c + 1] == -2) { u = !0, l[c + 1] = -1; continue } const d = t.map(n[c] + s); const f = d - i; if (f < 0 || f >= r.content.size) { u = !0; continue } const h = t.map(n[c + 1] + s, -1); const p = h - i; const { index: m, offset: g } = r.content.findIndex(f); const D = r.maybeChild(m); if (D && g == f && g + D.nodeSize == p) { const S = l[c + 2].mapInner(t, D, d + 1, n[c] + s + 1, o); S != re ? (l[c] = f, l[c + 1] = p, l[c + 2] = S) : (l[c + 1] = -2, u = !0) }
      else { u = !0 }
    }
  } if (u) { const c = Ff(l, n, e, t, i, s, o); const d = Nr(c, r, 0, o); e = d.local; for (let f = 0; f < l.length; f += 3)l[f + 1] < 0 && (l.splice(f, 3), f -= 3); for (let f = 0, h = 0; f < d.children.length; f += 3) { const p = d.children[f]; for (;h < l.length && l[h] < p;)h += 3; l.splice(h, 0, d.children[f], d.children[f + 1], d.children[f + 2]) } } return new U(e.sort($t), l)
} function wa(n, e) {
  if (!e || !n.length)
    return n; const t = []; for (let r = 0; r < n.length; r++) { const i = n[r]; t.push(new be(i.from + e, i.to + e, i.type)) } return t
} function Ff(n, e, t, r, i, s, o) { function l(a, u) { for (let c = 0; c < a.local.length; c++) { const d = a.local[c].map(r, i, u); d ? t.push(d) : o.onRemove && o.onRemove(a.local[c].spec) } for (let c = 0; c < a.children.length; c += 3)l(a.children[c + 2], a.children[c] + u + 1) } for (let a = 0; a < n.length; a += 3)n[a + 1] == -1 && l(n[a + 2], e[a] + s + 1); return t } function Fa(n, e, t) {
  if (e.isLeaf)
    return null; const r = t + e.nodeSize; let i = null; for (let s = 0, o; s < n.length; s++)(o = n[s]) && o.from > t && o.to < r && ((i || (i = [])).push(o), n[s] = null); return i
} function va(n) { const e = []; for (let t = 0; t < n.length; t++)n[t] != null && e.push(n[t]); return e } function Nr(n, e, t, r) { const i = []; let s = !1; e.forEach((l, a) => { const u = Fa(n, l, a + t); if (u) { s = !0; const c = Nr(u, l, t + a + 1, r); c != re && i.push(a, a + l.nodeSize, c) } }); const o = wa(s ? va(n) : n, -t).sort($t); for (let l = 0; l < o.length; l++)o[l].type.valid(e, o[l]) || (r.onRemove && r.onRemove(o[l].spec), o.splice(l--, 1)); return o.length || i.length ? new U(o, i) : re } function $t(n, e) { return n.from - e.from || n.to - e.to } function bs(n) {
  let e = n; for (let t = 0; t < e.length - 1; t++) {
    const r = e[t]; if (r.from != r.to) {
      for (let i = t + 1; i < e.length; i++) {
        const s = e[i]; if (s.from == r.from) { s.to != r.to && (e == n && (e = n.slice()), e[i] = s.copy(s.from, r.to), Gl(e, i + 1, s.copy(r.to, s.to))); continue }
        else { s.from < r.to && (e == n && (e = n.slice()), e[t] = r.copy(r.from, s.from), Gl(e, i, r.copy(s.from, r.to))); break }
      }
    }
  } return e
} function Gl(n, e, t) { for (;e < n.length && $t(t, n[e]) > 0;)e++; n.splice(e, 0, t) } function Wi(n) { const e = []; return n.someProp('decorations', (t) => { const r = t(n.state); r && r != re && e.push(r) }), n.cursorWrapper && e.push(U.create(n.state.doc, [n.cursorWrapper.deco])), $e.from(e) } const vf = { childList: !0, characterData: !0, characterDataOldValue: !0, attributes: !0, attributeOldValue: !0, subtree: !0 }; const Bf = Ce && mt <= 11; const cs = class {constructor() { this.anchorNode = null, this.anchorOffset = 0, this.focusNode = null, this.focusOffset = 0 }set(e) { this.anchorNode = e.anchorNode, this.anchorOffset = e.anchorOffset, this.focusNode = e.focusNode, this.focusOffset = e.focusOffset }clear() { this.anchorNode = this.focusNode = null }eq(e) { return e.anchorNode == this.anchorNode && e.anchorOffset == this.anchorOffset && e.focusNode == this.focusNode && e.focusOffset == this.focusOffset }}; const ds = class {
  constructor(e, t) { this.view = e, this.handleDOMChange = t, this.queue = [], this.flushingSoon = -1, this.observer = null, this.currentSelection = new cs(), this.onCharData = null, this.suppressingSelectionUpdates = !1, this.observer = window.MutationObserver && new window.MutationObserver((r) => { for (let i = 0; i < r.length; i++) this.queue.push(r[i]); Ce && mt <= 11 && r.some(i => i.type == 'childList' && i.removedNodes.length || i.type == 'characterData' && i.oldValue.length > i.target.nodeValue.length) ? this.flushSoon() : this.flush() }), Bf && (this.onCharData = (r) => { this.queue.push({ target: r.target, type: 'characterData', oldValue: r.prevValue }), this.flushSoon() }), this.onSelectionChange = this.onSelectionChange.bind(this) }flushSoon() { this.flushingSoon < 0 && (this.flushingSoon = window.setTimeout(() => { this.flushingSoon = -1, this.flush() }, 20)) }forceFlush() { this.flushingSoon > -1 && (window.clearTimeout(this.flushingSoon), this.flushingSoon = -1, this.flush()) }start() { this.observer && this.observer.observe(this.view.dom, vf), this.onCharData && this.view.dom.addEventListener('DOMCharacterDataModified', this.onCharData), this.connectSelection() }stop() { if (this.observer) { const e = this.observer.takeRecords(); if (e.length) { for (let t = 0; t < e.length; t++) this.queue.push(e[t]); window.setTimeout(() => this.flush(), 20) } this.observer.disconnect() } this.onCharData && this.view.dom.removeEventListener('DOMCharacterDataModified', this.onCharData), this.disconnectSelection() }connectSelection() { this.view.dom.ownerDocument.addEventListener('selectionchange', this.onSelectionChange) }disconnectSelection() { this.view.dom.ownerDocument.removeEventListener('selectionchange', this.onSelectionChange) }suppressSelectionUpdates() { this.suppressingSelectionUpdates = !0, setTimeout(() => this.suppressingSelectionUpdates = !1, 50) }onSelectionChange() {
    if (Kl(this.view)) {
      if (this.suppressingSelectionUpdates)
        return yt(this.view); if (Ce && mt <= 11 && !this.view.state.selection.empty) {
        const e = this.view.domSelection(); if (e.focusNode && jn(e.focusNode, e.focusOffset, e.anchorNode, e.anchorOffset))
          return this.flushSoon()
      } this.flush()
    }
  }

  setCurSelection() { this.currentSelection.set(this.view.domSelection()) }ignoreSelectionChange(e) {
    if (e.rangeCount == 0)
      return !0; const t = e.getRangeAt(0).commonAncestorContainer; const r = this.view.docView.nearestDesc(t); if (r && r.ignoreMutation({ type: 'selection', target: t.nodeType == 3 ? t.parentNode : t }))
      return this.setCurSelection(), !0
  }

  flush() {
    if (!this.view.docView || this.flushingSoon > -1)
      return; let e = this.observer ? this.observer.takeRecords() : []; this.queue.length && (e = this.queue.concat(e), this.queue.length = 0); const t = this.view.domSelection(); const r = !this.suppressingSelectionUpdates && !this.currentSelection.eq(t) && Kl(this.view) && !this.ignoreSelectionChange(t); let i = -1; let s = -1; let o = !1; const l = []; if (this.view.editable)
      for (let a = 0; a < e.length; a++) { const u = this.registerMutation(e[a], l); u && (i = i < 0 ? u.from : Math.min(u.from, i), s = s < 0 ? u.to : Math.max(u.to, s), u.typeOver && (o = !0)) } if (je && l.length > 1) { const a = l.filter(u => u.nodeName == 'BR'); if (a.length == 2) { const u = a[0]; const c = a[1]; u.parentNode && u.parentNode.parentNode == c.parentNode ? c.remove() : u.remove() } }(i > -1 || r) && (i > -1 && (this.view.docView.markDirty(i, s), If(this.view)), this.handleDOMChange(i, s, o, l), this.view.docView && this.view.docView.dirty ? this.view.updateState(this.view.state) : this.currentSelection.eq(t) || yt(this.view), this.currentSelection.set(t))
  }

  registerMutation(e, t) {
    if (t.includes(e.target))
      return null; const r = this.view.docView.nearestDesc(e.target); if (e.type == 'attributes' && (r == this.view.docView || e.attributeName == 'contenteditable' || e.attributeName == 'style' && !e.oldValue && !e.target.getAttribute('style')) || !r || r.ignoreMutation(e))
      return null; if (e.type == 'childList') {
      for (let c = 0; c < e.addedNodes.length; c++)t.push(e.addedNodes[c]); if (r.contentDOM && r.contentDOM != r.dom && !r.contentDOM.contains(e.target))
        return { from: r.posBefore, to: r.posAfter }; let i = e.previousSibling; let s = e.nextSibling; if (Ce && mt <= 11 && e.addedNodes.length)
        for (let c = 0; c < e.addedNodes.length; c++) { const { previousSibling: d, nextSibling: f } = e.addedNodes[c]; (!d || Array.prototype.indexOf.call(e.addedNodes, d) < 0) && (i = d), (!f || Array.prototype.indexOf.call(e.addedNodes, f) < 0) && (s = f) } const o = i && i.parentNode == e.target ? De(i) + 1 : 0; const l = r.localPosFromDOM(e.target, o, -1); const a = s && s.parentNode == e.target ? De(s) : e.target.childNodes.length; const u = r.localPosFromDOM(e.target, a, 1); return { from: l, to: u }
    }
    else { return e.type == 'attributes' ? { from: r.posAtStart - r.border, to: r.posAtEnd + r.border } : { from: r.posAtStart, to: r.posAtEnd, typeOver: e.target.nodeValue == e.oldValue } }
  }
}; let Yl = !1; function If(n) { Yl || (Yl = !0, getComputedStyle(n.dom).whiteSpace == 'normal' && console.warn('ProseMirror expects the CSS white-space property to be set, preferably to \'pre-wrap\'. It is recommended to load style/prosemirror.css from the prosemirror-view package.')) } function Pf(n, e, t) {
  let { node: r, fromOffset: i, toOffset: s, from: o, to: l } = n.docView.parseRange(e, t); const a = n.domSelection(); let u; const c = a.anchorNode; if (c && n.dom.contains(c.nodeType == 1 ? c : c.parentNode) && (u = [{ node: c, offset: a.anchorOffset }], hs(a) || u.push({ node: a.focusNode, offset: a.focusOffset })), ue && n.input.lastKeyCode === 8) {
    for (let g = s; g > i; g--) {
      const D = r.childNodes[g - 1]; const S = D.pmViewDesc; if (D.nodeName == 'BR' && !S) { s = g; break } if (!S || S.size)
        break
    }
  } const d = n.state.doc; const f = n.someProp('domParser') || Ae.fromSchema(n.state.schema); const h = d.resolve(o); let p = null; const m = f.parse(r, { topNode: h.parent, topMatch: h.parent.contentMatchAt(h.index()), topOpen: !0, from: i, to: s, preserveWhitespace: h.parent.type.whitespace == 'pre' ? 'full' : !0, findPositions: u, ruleFromNode: Rf, context: h }); if (u && u[0].pos != null) { const g = u[0].pos; let D = u[1] && u[1].pos; D == null && (D = g), p = { anchor: g + o, head: D + o } } return { doc: m, sel: p, from: o, to: l }
} function Rf(n) {
  const e = n.pmViewDesc; if (e)
    return e.parseRule(); if (n.nodeName == 'BR' && n.parentNode) {
    if (pe && /^(ul|ol)$/i.test(n.parentNode.nodeName)) { const t = document.createElement('div'); return t.appendChild(document.createElement('li')), { skip: t } }
    else if (n.parentNode.lastChild == n || pe && /^(tr|table)$/i.test(n.parentNode.nodeName)) { return { ignore: !0 } }
  }
  else if (n.nodeName == 'IMG' && n.getAttribute('mark-placeholder')) { return { ignore: !0 } } return null
} function Lf(n, e, t, r, i) {
  if (e < 0) { const O = n.input.lastSelectionTime > Date.now() - 50 ? n.input.lastSelectionOrigin : null; const le = ha(n, O); if (le && !n.state.selection.eq(le)) { const ut = n.state.tr.setSelection(le); O == 'pointer' ? ut.setMeta('pointer', !0) : O == 'key' && ut.scrollIntoView(), n.dispatch(ut) } return } const s = n.state.doc.resolve(e); const o = s.sharedDepth(t); e = s.before(o + 1), t = n.state.doc.resolve(t).after(o + 1); const l = n.state.selection; const a = Pf(n, e, t); if (ue && n.cursorWrapper && a.sel && a.sel.anchor == n.cursorWrapper.deco.from) { const O = n.cursorWrapper.deco.type.toDOM.nextSibling; const le = O && O.nodeValue ? O.nodeValue.length : 1; a.sel = { anchor: a.sel.anchor + le, head: a.sel.anchor + le } } const u = n.state.doc; const c = u.slice(a.from, a.to); let d; let f; n.input.lastKeyCode === 8 && Date.now() - 100 < n.input.lastKeyCodeTime ? (d = n.state.selection.to, f = 'end') : (d = n.state.selection.from, f = 'start'), n.input.lastKeyCode = null; let h = Hf(c.content, a.doc.content, a.from, d, f); if ((gn && n.input.lastIOSEnter > Date.now() - 225 || Ve) && i.some(O => O.nodeName == 'DIV' || O.nodeName == 'P') && (!h || h.endA >= h.endB) && n.someProp('handleKeyDown', O => O(n, hn(13, 'Enter')))) { n.input.lastIOSEnter = 0; return } if (!h)
    if (r && l instanceof E && !l.empty && l.$head.sameParent(l.$anchor) && !n.composing && !(a.sel && a.sel.anchor != a.sel.head)) { h = { start: l.from, endA: l.to, endB: l.to } }
 else { if (a.sel) { const O = Ql(n, n.state.doc, a.sel); O && !O.eq(n.state.selection) && n.dispatch(n.state.tr.setSelection(O)) } return }
  n.input.domChangeCount++, n.state.selection.from < n.state.selection.to && h.start == h.endB && n.state.selection instanceof E && (h.start > n.state.selection.from && h.start <= n.state.selection.from + 2 && n.state.selection.from >= a.from ? h.start = n.state.selection.from : h.endA < n.state.selection.to && h.endA >= n.state.selection.to - 2 && n.state.selection.to <= a.to && (h.endB += n.state.selection.to - h.endA, h.endA = n.state.selection.to)), Ce && mt <= 11 && h.endB == h.start + 1 && h.endA == h.start && h.start > a.from && a.doc.textBetween(h.start - a.from - 1, h.start - a.from + 1) == ' \xA0' && (h.start--, h.endA--, h.endB--); const p = a.doc.resolveNoCache(h.start - a.from); let m = a.doc.resolveNoCache(h.endB - a.from); const g = u.resolve(h.start); const D = p.sameParent(m) && p.parent.inlineContent && g.end() >= h.endA; let S; if ((gn && n.input.lastIOSEnter > Date.now() - 225 && (!D || i.some(O => O.nodeName == 'DIV' || O.nodeName == 'P')) || !D && p.pos < a.doc.content.size && (S = M.findFrom(a.doc.resolve(p.pos + 1), 1, !0)) && S.head == m.pos) && n.someProp('handleKeyDown', O => O(n, hn(13, 'Enter')))) { n.input.lastIOSEnter = 0; return } if (n.state.selection.anchor > h.start && Vf(u, h.start, h.endA, p, m) && n.someProp('handleKeyDown', O => O(n, hn(8, 'Backspace')))) { Ve && ue && n.domObserver.suppressSelectionUpdates(); return }ue && Ve && h.endB == h.start && (n.input.lastAndroidDelete = Date.now()), Ve && !D && p.start() != m.start() && m.parentOffset == 0 && p.depth == m.depth && a.sel && a.sel.anchor == a.sel.head && a.sel.head == h.endA && (h.endB -= 2, m = a.doc.resolveNoCache(h.endB - a.from), setTimeout(() => { n.someProp('handleKeyDown', (O) => { return O(n, hn(13, 'Enter')) }) }, 20)); const F = h.start; const B = h.endA; let I; let fe; let Q; if (D) {
    if (p.pos == m.pos) { Ce && mt <= 11 && p.parentOffset == 0 && (n.domObserver.suppressSelectionUpdates(), setTimeout(() => yt(n), 20)), I = n.state.tr.delete(F, B), fe = u.resolve(h.start).marksAcross(u.resolve(h.endA)) }
    else if (h.endA == h.endB && (Q = zf(p.parent.content.cut(p.parentOffset, m.parentOffset), g.parent.content.cut(g.parentOffset, h.endA - g.start())))) { I = n.state.tr, Q.type == 'add' ? I.addMark(F, B, Q.mark) : I.removeMark(F, B, Q.mark) }
    else if (p.parent.child(p.index()).isText && p.index() == m.index() - (m.textOffset ? 0 : 1)) {
      const O = p.parent.textBetween(p.parentOffset, m.parentOffset); if (n.someProp('handleTextInput', le => le(n, F, B, O)))
        return; I = n.state.tr.insertText(O, F, B)
    }
  } if (I || (I = n.state.tr.replace(F, B, a.doc.slice(h.start - a.from, h.endB - a.from))), a.sel) { const O = Ql(n, I.doc, a.sel); O && !(ue && Ve && n.composing && O.empty && (h.start != h.endB || n.input.lastAndroidDelete < Date.now() - 100) && (O.head == F || O.head == I.mapping.map(B) - 1) || Ce && O.empty && O.head == F) && I.setSelection(O) }fe && I.ensureMarks(fe), n.dispatch(I.scrollIntoView())
} function Ql(n, e, t) { return Math.max(t.anchor, t.head) > e.content.size ? null : ms(n, e.resolve(t.anchor), e.resolve(t.head)) } function zf(n, e) {
  const t = n.firstChild.marks; const r = e.firstChild.marks; let i = t; let s = r; let o; let l; let a; for (let c = 0; c < r.length; c++)i = r[c].removeFromSet(i); for (let c = 0; c < t.length; c++)s = t[c].removeFromSet(s); if (i.length == 1 && s.length == 0)
    l = i[0], o = 'add', a = c => c.mark(l.addToSet(c.marks)); else if (i.length == 0 && s.length == 1)
    l = s[0], o = 'remove', a = c => c.mark(l.removeFromSet(c.marks)); else return null; const u = []; for (let c = 0; c < e.childCount; c++)u.push(a(e.child(c))); if (y.from(u).eq(n))
    return { mark: l, type: o }
} function Vf(n, e, t, r, i) {
  if (!r.parent.isTextblock || t - e <= i.pos - r.pos || qi(r, !0, !1) < i.pos)
    return !1; const s = n.resolve(e); if (s.parentOffset < s.parent.content.size || !s.parent.isTextblock)
    return !1; const o = n.resolve(qi(s, !0, !0)); return !o.parent.isTextblock || o.pos > t || qi(o, !0, !1) < t ? !1 : r.parent.content.cut(r.parentOffset).eq(o.parent.content)
} function qi(n, e, t) { let r = n.depth; let i = e ? n.end() : n.pos; for (;r > 0 && (e || n.indexAfter(r) == n.node(r).childCount);)r--, i++, e = !1; if (t) { let s = n.node(r).maybeChild(n.indexAfter(r)); for (;s && !s.isLeaf;)s = s.firstChild, i++ } return i } function Hf(n, e, t, r, i) {
  let s = n.findDiffStart(e, t); if (s == null)
    return null; let { a: o, b: l } = n.findDiffEnd(e, t + n.size, t + e.size); if (i == 'end') { const a = Math.max(0, s - Math.min(o, l)); r -= o + a - s } return o < s && n.size < e.size ? (s -= r <= s && r >= o ? s - r : 0, l = s + (l - o), o = s) : l < s && (s -= r <= s && r >= l ? s - r : 0, o = s + (o - l), l = s), { start: s, endA: o, endB: l }
} const wr = class {
  constructor(e, t) { this._root = null, this.focused = !1, this.trackWrites = null, this.mounted = !1, this.markCursor = null, this.cursorWrapper = null, this.lastSelectedViewDesc = void 0, this.input = new is(), this.prevDirectPlugins = [], this.pluginViews = [], this.dragging = null, this._props = t, this.state = t.state, this.directPlugins = t.plugins || [], this.directPlugins.forEach(na), this.dispatch = this.dispatch.bind(this), this.dom = e && e.mount || document.createElement('div'), e && (e.appendChild ? e.appendChild(this.dom) : typeof e == 'function' ? e(this.dom) : e.mount && (this.mounted = !0)), this.editable = ea(this), Zl(this), this.nodeViews = ta(this), this.docView = Rl(this.state.doc, Xl(this), Wi(this), this.dom, this), this.domObserver = new ds(this, (r, i, s, o) => Lf(this, r, i, s, o)), this.domObserver.start(), pf(this), this.updatePluginViews() } get composing() { return this.input.composing } get props() { if (this._props.state != this.state) { const e = this._props; this._props = {}; for (const t in e) this._props[t] = e[t]; this._props.state = this.state } return this._props }update(e) { e.handleDOMEvents != this._props.handleDOMEvents && ss(this), this._props = e, e.plugins && (e.plugins.forEach(na), this.directPlugins = e.plugins), this.updateStateInner(e.state, !0) }setProps(e) { const t = {}; for (const r in this._props)t[r] = this._props[r]; t.state = this.state; for (const r in e)t[r] = e[r]; this.update(t) }updateState(e) { this.updateStateInner(e, this.state.plugins != e.plugins) }updateStateInner(e, t) {
    const r = this.state; let i = !1; let s = !1; if (e.storedMarks && this.composing && (Ta(this), s = !0), this.state = e, t) { const d = ta(this); Kf(d, this.nodeViews) && (this.nodeViews = d, i = !0), ss(this) } this.editable = ea(this), Zl(this); const o = Wi(this); const l = Xl(this); const a = t ? 'reset' : e.scrollToSelection > r.scrollToSelection ? 'to selection' : 'preserve'; const u = i || !this.docView.matchesNode(e.doc, l, o); (u || !e.selection.eq(r.selection)) && (s = !0); const c = a == 'preserve' && s && this.dom.style.overflowAnchor == null && Rd(this); if (s) { this.domObserver.stop(); let d = u && (Ce || ue) && !this.composing && !r.selection.empty && !e.selection.empty && $f(r.selection, e.selection); if (u) { const f = ue ? this.trackWrites = this.domSelection().focusNode : null; (i || !this.docView.update(e.doc, l, o, this)) && (this.docView.updateOuterDeco([]), this.docView.destroy(), this.docView = Rl(e.doc, l, o, this.dom, this)), f && !this.trackWrites && (d = !0) }d || !(this.input.mouseDown && this.domObserver.currentSelection.eq(this.domSelection()) && sf(this)) ? yt(this, d) : (ma(this, e.selection), this.domObserver.setCurSelection()), this.domObserver.start() } if (this.updatePluginViews(r), a == 'reset') { this.dom.scrollTop = 0 }
    else if (a == 'to selection') {
      const d = this.domSelection().focusNode; if (!this.someProp('handleScrollToSelection', f => f(this))) {
        if (e.selection instanceof k) { const f = this.docView.domAfterPos(e.selection.from); f.nodeType == 1 && Fl(this, f.getBoundingClientRect(), d) }
        else { Fl(this, this.coordsAtPos(e.selection.head, 1), d) }
      }
    }
    else { c && Ld(c) }
  }

  destroyPluginViews() { let e; for (;e = this.pluginViews.pop();)e.destroy && e.destroy() }updatePluginViews(e) {
    if (!e || e.plugins != this.state.plugins || this.directPlugins != this.prevDirectPlugins) { this.prevDirectPlugins = this.directPlugins, this.destroyPluginViews(); for (let t = 0; t < this.directPlugins.length; t++) { const r = this.directPlugins[t]; r.spec.view && this.pluginViews.push(r.spec.view(this)) } for (let t = 0; t < this.state.plugins.length; t++) { const r = this.state.plugins[t]; r.spec.view && this.pluginViews.push(r.spec.view(this)) } }
    else { for (let t = 0; t < this.pluginViews.length; t++) { const r = this.pluginViews[t]; r.update && r.update(this, e) } }
  }

  someProp(e, t) {
    const r = this._props && this._props[e]; let i; if (r != null && (i = t ? t(r) : r))
      return i; for (let o = 0; o < this.directPlugins.length; o++) {
      const l = this.directPlugins[o].props[e]; if (l != null && (i = t ? t(l) : l))
        return i
    } const s = this.state.plugins; if (s) {
      for (let o = 0; o < s.length; o++) {
        const l = s[o].props[e]; if (l != null && (i = t ? t(l) : l))
          return i
      }
    }
  }

  hasFocus() { return this.root.activeElement == this.dom }focus() { this.domObserver.stop(), this.editable && zd(this.dom), yt(this), this.domObserver.start() } get root() {
    const e = this._root; if (e == null) {
      for (let t = this.dom.parentNode; t; t = t.parentNode) {
        if (t.nodeType == 9 || t.nodeType == 11 && t.host)
          return t.getSelection || (Object.getPrototypeOf(t).getSelection = () => t.ownerDocument.getSelection()), this._root = t
      }
    } return e || document
  }

  posAtCoords(e) { return jd(this, e) }coordsAtPos(e, t = 1) { return aa(this, e, t) }domAtPos(e, t = 0) { return this.docView.domFromPos(e, t) }nodeDOM(e) { const t = this.docView.descAt(e); return t ? t.nodeDOM : null }posAtDOM(e, t, r = -1) {
    const i = this.docView.posFromDOM(e, t, r); if (i == null)
      throw new RangeError('DOM position not inside the editor'); return i
  }

  endOfTextblock(e, t) { return Ud(this, t || this.state, e) }destroy() { !this.docView || (mf(this), this.destroyPluginViews(), this.mounted ? (this.docView.update(this.state.doc, [], Wi(this), this), this.dom.textContent = '') : this.dom.parentNode && this.dom.parentNode.removeChild(this.dom), this.docView.destroy(), this.docView = null) } get isDestroyed() { return this.docView == null }dispatchEvent(e) { return yf(this, e) }dispatch(e) { const t = this._props.dispatchTransaction; t ? t.call(this, e) : this.updateState(this.state.apply(e)) }domSelection() { return this.root.getSelection() }
}; function Xl(n) {
  const e = Object.create(null); return e.class = 'ProseMirror', e.contenteditable = String(n.editable), e.translate = 'no', n.someProp('attributes', (t) => {
    if (typeof t == 'function' && (t = t(n.state)), t)
      for (const r in t)r == 'class' && (e.class += ` ${t[r]}`), r == 'style' ? e.style = (e.style ? `${e.style};` : '') + t[r] : !e[r] && r != 'contenteditable' && r != 'nodeName' && (e[r] = String(t[r]))
  }), [be.node(0, n.state.doc.content.size, e)]
} function Zl(n) {
  if (n.markCursor) { const e = document.createElement('img'); e.className = 'ProseMirror-separator', e.setAttribute('mark-placeholder', 'true'), e.setAttribute('alt', ''), n.cursorWrapper = { dom: e, deco: be.widget(n.state.selection.head, e, { raw: !0, marks: n.markCursor }) } }
  else { n.cursorWrapper = null }
} function ea(n) { return !n.someProp('editable', e => e(n.state) === !1) } function $f(n, e) { const t = Math.min(n.$anchor.sharedDepth(n.head), e.$anchor.sharedDepth(e.head)); return n.$anchor.start(t) != e.$anchor.start(t) } function ta(n) { const e = Object.create(null); function t(r) { for (const i in r)Object.prototype.hasOwnProperty.call(e, i) || (e[i] = r[i]) } return n.someProp('nodeViews', t), n.someProp('markViews', t), e } function Kf(n, e) {
  let t = 0; let r = 0; for (const i in n) {
    if (n[i] != e[i])
      return !0; t++
  } for (const i in e)r++; return t != r
} function na(n) {
  if (n.spec.state || n.spec.filterTransaction || n.spec.appendTransaction)
    throw new RangeError('Plugins passed directly to the view must not have a state component')
} const nt = { 8: 'Backspace', 9: 'Tab', 10: 'Enter', 12: 'NumLock', 13: 'Enter', 16: 'Shift', 17: 'Control', 18: 'Alt', 20: 'CapsLock', 27: 'Escape', 32: ' ', 33: 'PageUp', 34: 'PageDown', 35: 'End', 36: 'Home', 37: 'ArrowLeft', 38: 'ArrowUp', 39: 'ArrowRight', 40: 'ArrowDown', 44: 'PrintScreen', 45: 'Insert', 46: 'Delete', 59: ';', 61: '=', 91: 'Meta', 92: 'Meta', 106: '*', 107: '+', 108: ',', 109: '-', 110: '.', 111: '/', 144: 'NumLock', 145: 'ScrollLock', 160: 'Shift', 161: 'Shift', 162: 'Control', 163: 'Control', 164: 'Alt', 165: 'Alt', 173: '-', 186: ';', 187: '=', 188: ',', 189: '-', 190: '.', 191: '/', 192: '`', 219: '[', 220: '\\', 221: ']', 222: '\'' }; const Ir = { 48: ')', 49: '!', 50: '@', 51: '#', 52: '$', 53: '%', 54: '^', 55: '&', 56: '*', 57: '(', 59: ':', 61: '+', 173: '_', 186: ':', 187: '+', 188: '<', 189: '_', 190: '>', 191: '?', 192: '~', 219: '{', 220: '|', 221: '}', 222: '"' }; const Ba = typeof navigator < 'u' && /Chrome\/(\d+)/.exec(navigator.userAgent); const Wg = typeof navigator < 'u' && /Gecko\/\d+/.test(navigator.userAgent); const jf = typeof navigator < 'u' && /Mac/.test(navigator.platform); const Wf = typeof navigator < 'u' && /MSIE \d|Trident\/(?:[7-9]|\d{2,})\..*rv:(\d+)/.exec(navigator.userAgent); const qf = jf || Ba && +Ba[1] < 57; for (W = 0; W < 10; W++)nt[48 + W] = nt[96 + W] = String(W); var W; for (W = 1; W <= 24; W++)nt[W + 111] = `F${W}`; var W; for (W = 65; W <= 90; W++)nt[W] = String.fromCharCode(W + 32), Ir[W] = String.fromCharCode(W); var W; for (Br in nt)Ir.hasOwnProperty(Br) || (Ir[Br] = nt[Br]); let Br; function Ia(n) { const e = qf && (n.ctrlKey || n.altKey || n.metaKey) || Wf && n.shiftKey && n.key && n.key.length == 1 || n.key == 'Unidentified'; let t = !e && n.key || (n.shiftKey ? Ir : nt)[n.keyCode] || n.key || 'Unidentified'; return t == 'Esc' && (t = 'Escape'), t == 'Del' && (t = 'Delete'), t == 'Left' && (t = 'ArrowLeft'), t == 'Up' && (t = 'ArrowUp'), t == 'Right' && (t = 'ArrowRight'), t == 'Down' && (t = 'ArrowDown'), t } const _f = typeof navigator < 'u' ? /Mac|iP(hone|[oa]d)/.test(navigator.platform) : !1; function Jf(n) {
  const e = n.split(/-(?!$)/); let t = e[e.length - 1]; t == 'Space' && (t = ' '); let r, i, s, o; for (let l = 0; l < e.length - 1; l++) {
    const a = e[l]; if (/^(cmd|meta|m)$/i.test(a))
      o = !0; else if (/^a(lt)?$/i.test(a))
      r = !0; else if (/^(c|ctrl|control)$/i.test(a))
      i = !0; else if (/^s(hift)?$/i.test(a))
      s = !0; else if (/^mod$/i.test(a))
      _f ? o = !0 : i = !0; else throw new Error(`Unrecognized modifier name: ${a}`)
  } return r && (t = `Alt-${t}`), i && (t = `Ctrl-${t}`), o && (t = `Meta-${t}`), s && (t = `Shift-${t}`), t
} function Uf(n) { const e = Object.create(null); for (const t in n)e[Jf(t)] = n[t]; return e } function Cs(n, e, t) { return e.altKey && (n = `Alt-${n}`), e.ctrlKey && (n = `Ctrl-${n}`), e.metaKey && (n = `Meta-${n}`), t !== !1 && e.shiftKey && (n = `Shift-${n}`), n } function Pa(n) { return new L({ props: { handleKeyDown: ks(n) } }) } function ks(n) {
  const e = Uf(n); return function (t, r) {
    const i = Ia(r); const s = i.length == 1 && i != ' '; let o; const l = e[Cs(i, r, !s)]; if (l && l(t.state, t.dispatch, t))
      return !0; if (s && (r.shiftKey || r.altKey || r.metaKey || i.charCodeAt(0) > 127) && (o = nt[r.keyCode]) && o != i) {
      const a = e[Cs(o, r, !0)]; if (a && a(t.state, t.dispatch, t))
        return !0
    }
    else if (s && r.shiftKey) {
      const a = e[Cs(i, r, !0)]; if (a && a(t.state, t.dispatch, t))
        return !0
    } return !1
  }
} const Pr = (n, e) => n.selection.empty ? !1 : (e && e(n.tr.deleteSelection().scrollIntoView()), !0); const xs = (n, e, t) => {
  const { $cursor: r } = n.selection; if (!r || (t ? !t.endOfTextblock('backward', n) : r.parentOffset > 0))
    return !1; const i = La(r); if (!i) { const o = r.blockRange(); const l = o && Qe(o); return l == null ? !1 : (e && e(n.tr.lift(o, l).scrollIntoView()), !0) } const s = i.nodeBefore; if (!s.type.spec.isolating && $a(n, i, e))
    return !0; if (r.parent.content.size == 0 && (bn(s, 'end') || k.isSelectable(s))) { const o = xr(n.doc, r.before(), r.after(), b.empty); if (o && o.slice.size < o.to - o.from) { if (e) { const l = n.tr.step(o); l.setSelection(bn(s, 'end') ? M.findFrom(l.doc.resolve(l.mapping.map(i.pos, -1)), -1) : k.create(l.doc, i.pos - s.nodeSize)), e(l.scrollIntoView()) } return !0 } } return s.isAtom && i.depth == r.depth - 1 ? (e && e(n.tr.delete(i.pos - s.nodeSize, i.pos).scrollIntoView()), !0) : !1
}; function bn(n, e, t = !1) {
  for (let r = n; r; r = e == 'start' ? r.firstChild : r.lastChild) {
    if (r.isTextblock)
      return !0; if (t && r.childCount != 1)
      return !1
  } return !1
} const Es = (n, e, t) => {
  const { $head: r, empty: i } = n.selection; let s = r; if (!i)
    return !1; if (r.parent.isTextblock) {
    if (t ? !t.endOfTextblock('backward', n) : r.parentOffset > 0)
      return !1; s = La(r)
  } const o = s && s.nodeBefore; return !o || !k.isSelectable(o) ? !1 : (e && e(n.tr.setSelection(k.create(n.doc, s.pos - o.nodeSize)).scrollIntoView()), !0)
}; function La(n) {
  if (!n.parent.type.spec.isolating) {
    for (let e = n.depth - 1; e >= 0; e--) {
      if (n.index(e) > 0)
        return n.doc.resolve(n.before(e + 1)); if (n.node(e).type.spec.isolating)
        break
    }
  } return null
} const As = (n, e, t) => {
  const { $cursor: r } = n.selection; if (!r || (t ? !t.endOfTextblock('forward', n) : r.parentOffset < r.parent.content.size))
    return !1; const i = za(r); if (!i)
    return !1; const s = i.nodeAfter; if ($a(n, i, e))
    return !0; if (r.parent.content.size == 0 && (bn(s, 'start') || k.isSelectable(s))) { const o = xr(n.doc, r.before(), r.after(), b.empty); if (o && o.slice.size < o.to - o.from) { if (e) { const l = n.tr.step(o); l.setSelection(bn(s, 'start') ? M.findFrom(l.doc.resolve(l.mapping.map(i.pos)), 1) : k.create(l.doc, l.mapping.map(i.pos))), e(l.scrollIntoView()) } return !0 } } return s.isAtom && i.depth == r.depth - 1 ? (e && e(n.tr.delete(i.pos, i.pos + s.nodeSize).scrollIntoView()), !0) : !1
}; const Ms = (n, e, t) => {
  const { $head: r, empty: i } = n.selection; let s = r; if (!i)
    return !1; if (r.parent.isTextblock) {
    if (t ? !t.endOfTextblock('forward', n) : r.parentOffset < r.parent.content.size)
      return !1; s = za(r)
  } const o = s && s.nodeAfter; return !o || !k.isSelectable(o) ? !1 : (e && e(n.tr.setSelection(k.create(n.doc, s.pos)).scrollIntoView()), !0)
}; function za(n) {
  if (!n.parent.type.spec.isolating) {
    for (let e = n.depth - 1; e >= 0; e--) {
      const t = n.node(e); if (n.index(e) + 1 < t.childCount)
        return n.doc.resolve(n.after(e + 1)); if (t.type.spec.isolating)
        break
    }
  } return null
} const Va = (n, e) => { const { $from: t, $to: r } = n.selection; const i = t.blockRange(r); const s = i && Qe(i); return s == null ? !1 : (e && e(n.tr.lift(i, s).scrollIntoView()), !0) }; const Os = (n, e) => {
  const { $head: t, $anchor: r } = n.selection; return !t.parent.type.spec.code || !t.sameParent(r)
    ? !1
    : (e && e(n.tr.insertText(`
`).scrollIntoView()), !0)
}; function Ts(n) {
  for (let e = 0; e < n.edgeCount; e++) {
    const { type: t } = n.edge(e); if (t.isTextblock && !t.hasRequiredAttrs())
      return t
  } return null
} const Ns = (n, e) => {
  const { $head: t, $anchor: r } = n.selection; if (!t.parent.type.spec.code || !t.sameParent(r))
    return !1; const i = t.node(-1); const s = t.indexAfter(-1); const o = Ts(i.contentMatchAt(s)); if (!o || !i.canReplaceWith(s, s, o))
    return !1; if (e) { const l = t.after(); const a = n.tr.replaceWith(l, l, o.createAndFill()); a.setSelection(M.near(a.doc.resolve(l), 1)), e(a.scrollIntoView()) } return !0
}; const ws = (n, e) => {
  const t = n.selection; const { $from: r, $to: i } = t; if (t instanceof q || r.parent.inlineContent || i.parent.inlineContent)
    return !1; const s = Ts(i.parent.contentMatchAt(i.indexAfter())); if (!s || !s.isTextblock)
    return !1; if (e) { const o = (!r.parentOffset && i.index() < i.parent.childCount ? r : i).pos; const l = n.tr.insert(o, s.createAndFill()); l.setSelection(E.create(l.doc, o + 1)), e(l.scrollIntoView()) } return !0
}; const Fs = (n, e) => {
  const { $cursor: t } = n.selection; if (!t || t.parent.content.size)
    return !1; if (t.depth > 1 && t.after() != t.end(-1)) {
    const s = t.before(); if (Oe(n.doc, s))
      return e && e(n.tr.split(s).scrollIntoView()), !0
  } const r = t.blockRange(); const i = r && Qe(r); return i == null ? !1 : (e && e(n.tr.lift(r, i).scrollIntoView()), !0)
}; const Gf = (n, e) => {
  const { $from: t, $to: r } = n.selection; if (n.selection instanceof k && n.selection.node.isBlock)
    return !t.parentOffset || !Oe(n.doc, t.pos) ? !1 : (e && e(n.tr.split(t.pos).scrollIntoView()), !0); if (!t.parent.isBlock)
    return !1; if (e) { const i = r.parentOffset == r.parent.content.size; const s = n.tr; (n.selection instanceof E || n.selection instanceof q) && s.deleteSelection(); const o = t.depth == 0 ? null : Ts(t.node(-1).contentMatchAt(t.indexAfter(-1))); let l = i && o ? [{ type: o }] : void 0; let a = Oe(s.doc, s.mapping.map(t.pos), 1, l); if (!l && !a && Oe(s.doc, s.mapping.map(t.pos), 1, o ? [{ type: o }] : void 0) && (o && (l = [{ type: o }]), a = !0), a && (s.split(s.mapping.map(t.pos), 1, l), !i && !t.parentOffset && t.parent.type != o)) { const u = s.mapping.map(t.before()); const c = s.doc.resolve(u); o && t.node(-1).canReplaceWith(c.index(), c.index() + 1, o) && s.setNodeMarkup(s.mapping.map(t.before()), o) }e(s.scrollIntoView()) } return !0
}; const Ha = (n, e) => { const { $from: t, to: r } = n.selection; let i; const s = t.sharedDepth(r); return s == 0 ? !1 : (i = t.before(s), e && e(n.tr.setSelection(k.create(n.doc, i))), !0) }; const Yf = (n, e) => (e && e(n.tr.setSelection(new q(n.doc))), !0); function Qf(n, e, t) { const r = e.nodeBefore; const i = e.nodeAfter; const s = e.index(); return !r || !i || !r.type.compatibleContent(i.type) ? !1 : !r.content.size && e.parent.canReplace(s - 1, s) ? (t && t(n.tr.delete(e.pos - r.nodeSize, e.pos).scrollIntoView()), !0) : !e.parent.canReplace(s, s + 1) || !(i.isTextblock || Pt(n.doc, e.pos)) ? !1 : (t && t(n.tr.clearIncompatible(e.pos, r.type, r.contentMatchAt(r.childCount)).join(e.pos).scrollIntoView()), !0) } function $a(n, e, t) {
  const r = e.nodeBefore; const i = e.nodeAfter; let s; let o; if (r.type.spec.isolating || i.type.spec.isolating)
    return !1; if (Qf(n, e, t))
    return !0; const l = e.parent.canReplace(e.index(), e.index() + 1); if (l && (s = (o = r.contentMatchAt(r.childCount)).findWrapping(i.type)) && o.matchType(s[0] || i.type).validEnd) { if (t) { const d = e.pos + i.nodeSize; let f = y.empty; for (let m = s.length - 1; m >= 0; m--)f = y.from(s[m].create(null, f)); f = y.from(r.copy(f)); const h = n.tr.step(new z(e.pos - 1, d, e.pos, d, new b(f, 1, 0), s.length, !0)); const p = d + 2 * s.length; Pt(h.doc, p) && h.join(p), t(h.scrollIntoView()) } return !0 } const a = M.findFrom(e, 1); const u = a && a.$from.blockRange(a.$to); const c = u && Qe(u); if (c != null && c >= e.depth)
    return t && t(n.tr.lift(u, c).scrollIntoView()), !0; if (l && bn(i, 'start', !0) && bn(r, 'end')) { let d = r; const f = []; for (;f.push(d), !d.isTextblock;)d = d.lastChild; let h = i; let p = 1; for (;!h.isTextblock; h = h.firstChild)p++; if (d.canReplace(d.childCount, d.childCount, h.content)) { if (t) { let m = y.empty; for (let D = f.length - 1; D >= 0; D--)m = y.from(f[D].copy(m)); const g = n.tr.step(new z(e.pos - f.length, e.pos + i.nodeSize, e.pos + p, e.pos + i.nodeSize - p, new b(m, f.length, 0), 0, !0)); t(g.scrollIntoView()) } return !0 } } return !1
} function Ka(n) {
  return function (e, t) {
    const r = e.selection; const i = n < 0 ? r.$from : r.$to; let s = i.depth; for (;i.node(s).isInline;) {
      if (!s)
        return !1; s--
    } return i.node(s).isTextblock ? (t && t(e.tr.setSelection(E.create(e.doc, n < 0 ? i.start(s) : i.end(s)))), !0) : !1
  }
} const vs = Ka(-1); const Bs = Ka(1); function ja(n, e = null) { return function (t, r) { const { $from: i, $to: s } = t.selection; const o = i.blockRange(s); const l = o && an(o, n, e); return l ? (r && r(t.tr.wrap(o, l).scrollIntoView()), !0) : !1 } } function Is(n, e = null) {
  return function (t, r) {
    const { from: i, to: s } = t.selection; let o = !1; return t.doc.nodesBetween(i, s, (l, a) => {
      if (o)
        return !1; if (!(!l.isTextblock || l.hasMarkup(n, e)))
        if (l.type == n) { o = !0 }
 else { const u = t.doc.resolve(a); const c = u.index(); o = u.parent.canReplaceWith(c, c + 1, n) }
    }), o ? (r && r(t.tr.setBlockType(i, s, n, e).scrollIntoView()), !0) : !1
  }
} function Ps(...n) {
  return function (e, t, r) {
    for (let i = 0; i < n.length; i++) {
      if (n[i](e, t, r))
        return !0
    } return !1
  }
} const Ss = Ps(Pr, xs, Es); const Ra = Ps(Pr, As, Ms); const bt = { 'Enter': Ps(Os, ws, Fs, Gf), 'Mod-Enter': Ns, 'Backspace': Ss, 'Mod-Backspace': Ss, 'Shift-Backspace': Ss, 'Delete': Ra, 'Mod-Delete': Ra, 'Mod-a': Yf }; const Xf = { 'Ctrl-h': bt.Backspace, 'Alt-Backspace': bt['Mod-Backspace'], 'Ctrl-d': bt.Delete, 'Ctrl-Alt-Backspace': bt['Mod-Delete'], 'Alt-Delete': bt['Mod-Delete'], 'Alt-d': bt['Mod-Delete'], 'Ctrl-a': vs, 'Ctrl-e': Bs }; for (const n in bt)Xf[n] = bt[n]; const Zg = typeof navigator < 'u' ? /Mac|iP(hone|[oa]d)/.test(navigator.platform) : typeof os < 'u' && os.platform ? os.platform() == 'darwin' : !1; function Wa(n, e = null) {
  return function (t, r) {
    const { $from: i, $to: s } = t.selection; let o = i.blockRange(s); let l = !1; let a = o; if (!o)
      return !1; if (o.depth >= 2 && i.node(o.depth - 1).type.compatibleContent(n) && o.startIndex == 0) {
      if (i.index(o.depth - 1) == 0)
        return !1; const c = t.doc.resolve(o.start - 2); a = new Bt(c, c, o.depth), o.endIndex < o.parent.childCount && (o = new Bt(i, t.doc.resolve(s.end(o.depth)), o.depth)), l = !0
    } const u = an(a, n, e, o); return u ? (r && r(Zf(t.tr, o, u, l, n).scrollIntoView()), !0) : !1
  }
} function Zf(n, e, t, r, i) { let s = y.empty; for (let c = t.length - 1; c >= 0; c--)s = y.from(t[c].type.create(t[c].attrs, s)); n.step(new z(e.start - (r ? 2 : 0), e.end, e.start, e.end, new b(s, 0, 0), t.length, !0)); let o = 0; for (let c = 0; c < t.length; c++)t[c].type == i && (o = c + 1); const l = t.length - o; let a = e.start + t.length - (r ? 2 : 0); const u = e.parent; for (let c = e.startIndex, d = e.endIndex, f = !0; c < d; c++, f = !1)!f && Oe(n.doc, a, l) && (n.split(a, l), a += 2 * l), a += u.child(c).nodeSize; return n } function qa(n) { return function (e, t) { const { $from: r, $to: i } = e.selection; const s = r.blockRange(i, o => o.childCount > 0 && o.firstChild.type == n); return s ? t ? r.node(s.depth - 1).type == n ? eh(e, t, n, s) : th(e, t, s) : !0 : !1 } } function eh(n, e, t, r) { const i = n.tr; const s = r.end; const o = r.$to.end(r.depth); return s < o && (i.step(new z(s - 1, o, s, o, new b(y.from(t.create(null, r.parent.copy())), 1, 0), 1, !0)), r = new Bt(i.doc.resolve(r.$from.pos), i.doc.resolve(o), r.depth)), e(i.lift(r, Qe(r)).scrollIntoView()), !0 } function th(n, e, t) {
  const r = n.tr; const i = t.parent; for (let h = t.end, p = t.endIndex - 1, m = t.startIndex; p > m; p--)h -= i.child(p).nodeSize, r.delete(h - 1, h + 1); const s = r.doc.resolve(t.start); const o = s.nodeAfter; if (r.mapping.map(t.end) != t.start + s.nodeAfter.nodeSize)
    return !1; const l = t.startIndex == 0; const a = t.endIndex == i.childCount; const u = s.node(-1); const c = s.index(-1); if (!u.canReplace(c + (l ? 0 : 1), c + 1, o.content.append(a ? y.empty : y.from(i))))
    return !1; const d = s.pos; const f = d + o.nodeSize; return r.step(new z(d - (l ? 1 : 0), f + (a ? 1 : 0), d + 1, f - 1, new b((l ? y.empty : y.from(i.copy(y.empty))).append(a ? y.empty : y.from(i.copy(y.empty))), l ? 0 : 1, a ? 0 : 1), l ? 0 : 1)), e(r.scrollIntoView()), !0
} function _a(n) {
  return function (e, t) {
    const { $from: r, $to: i } = e.selection; const s = r.blockRange(i, u => u.childCount > 0 && u.firstChild.type == n); if (!s)
      return !1; const o = s.startIndex; if (o == 0)
      return !1; const l = s.parent; const a = l.child(o - 1); if (a.type != n)
      return !1; if (t) { const u = a.lastChild && a.lastChild.type == l.type; const c = y.from(u ? n.create() : null); const d = new b(y.from(n.create(null, y.from(l.type.create(null, c)))), u ? 3 : 1, 0); const f = s.start; const h = s.end; t(e.tr.step(new z(f - (u ? 3 : 1), h, f, h, d, 1, !0)).scrollIntoView()) } return !0
  }
} function Vr(n) { const { state: e, transaction: t } = n; let { selection: r } = t; let { doc: i } = t; let { storedMarks: s } = t; return { ...e, apply: e.apply.bind(e), applyTransaction: e.applyTransaction.bind(e), filterTransaction: e.filterTransaction, plugins: e.plugins, schema: e.schema, reconfigure: e.reconfigure.bind(e), toJSON: e.toJSON.bind(e), get storedMarks() { return s }, get selection() { return r }, get doc() { return i }, get tr() { return r = t.selection, i = t.doc, s = t.storedMarks, t } } } const Cn = class {constructor(e) { this.editor = e.editor, this.rawCommands = this.editor.extensionManager.commands, this.customState = e.state } get hasCustomState() { return !!this.customState } get state() { return this.customState || this.editor.state } get commands() { const { rawCommands: e, editor: t, state: r } = this; const { view: i } = t; const { tr: s } = r; const o = this.buildProps(s); return Object.fromEntries(Object.entries(e).map(([l, a]) => [l, (...c) => { const d = a(...c)(o); return !s.getMeta('preventDispatch') && !this.hasCustomState && i.dispatch(s), d }])) } get chain() { return () => this.createChain() } get can() { return () => this.createCan() }createChain(e, t = !0) { const { rawCommands: r, editor: i, state: s } = this; const { view: o } = i; const l = []; const a = !!e; const u = e || s.tr; const c = () => (!a && t && !u.getMeta('preventDispatch') && !this.hasCustomState && o.dispatch(u), l.every(f => f === !0)); const d = { ...Object.fromEntries(Object.entries(r).map(([f, h]) => [f, (...m) => { const g = this.buildProps(u, t); const D = h(...m)(g); return l.push(D), d }])), run: c }; return d }createCan(e) { const { rawCommands: t, state: r } = this; const i = !1; const s = e || r.tr; const o = this.buildProps(s, i); return { ...Object.fromEntries(Object.entries(t).map(([a, u]) => [a, (...c) => u(...c)({ ...o, dispatch: void 0 })])), chain: () => this.createChain(s, i) } }buildProps(e, t = !0) { const { rawCommands: r, editor: i, state: s } = this; const { view: o } = i; s.storedMarks && e.setStoredMarks(s.storedMarks); const l = { tr: e, editor: i, view: o, state: Vr({ state: s, transaction: e }), dispatch: t ? () => {} : void 0, chain: () => this.createChain(e), can: () => this.createCan(e), get commands() { return Object.fromEntries(Object.entries(r).map(([a, u]) => [a, (...c) => u(...c)(l)])) } }; return l }}; const Vs = class {constructor() { this.callbacks = {} }on(e, t) { return this.callbacks[e] || (this.callbacks[e] = []), this.callbacks[e].push(t), this }emit(e, ...t) { const r = this.callbacks[e]; return r && r.forEach(i => i.apply(this, t)), this }off(e, t) { const r = this.callbacks[e]; return r && (t ? this.callbacks[e] = r.filter(i => i !== t) : delete this.callbacks[e]), this }removeAllListeners() { this.callbacks = {} }}; function x(n, e, t) { return n.config[e] === void 0 && n.parent ? x(n.parent, e, t) : typeof n.config[e] == 'function' ? n.config[e].bind({ ...t, parent: n.parent ? x(n.parent, e, t) : null }) : n.config[e] } function Hr(n) { const e = n.filter(i => i.type === 'extension'); const t = n.filter(i => i.type === 'node'); const r = n.filter(i => i.type === 'mark'); return { baseExtensions: e, nodeExtensions: t, markExtensions: r } } function nu(n) {
  const e = []; const { nodeExtensions: t, markExtensions: r } = Hr(n); const i = [...t, ...r]; const s = { default: null, rendered: !0, renderHTML: null, parseHTML: null, keepOnSplit: !0, isRequired: !1 }; return n.forEach((o) => {
    const l = { name: o.name, options: o.options, storage: o.storage }; const a = x(o, 'addGlobalAttributes', l); if (!a)
      return; a().forEach((c) => { c.types.forEach((d) => { Object.entries(c.attributes).forEach(([f, h]) => { e.push({ type: d, name: f, attribute: { ...s, ...h } }) }) }) })
  }), i.forEach((o) => {
    const l = { name: o.name, options: o.options, storage: o.storage }; const a = x(o, 'addAttributes', l); if (!a)
      return; const u = a(); Object.entries(u).forEach(([c, d]) => { const f = { ...s, ...d }; d.isRequired && d.default === void 0 && delete f.default, e.push({ type: o.name, name: c, attribute: f }) })
  }), e
} function G(n, e) {
  if (typeof n == 'string') {
    if (!e.nodes[n])
      throw new Error(`There is no node type named '${n}'. Maybe you forgot to add the extension?`); return e.nodes[n]
  } return n
} function v(...n) { return n.filter(e => !!e).reduce((e, t) => { const r = { ...e }; return Object.entries(t).forEach(([i, s]) => { if (!r[i]) { r[i] = s; return }i === 'class' ? r[i] = [r[i], s].join(' ') : i === 'style' ? r[i] = [r[i], s].join('; ') : r[i] = s }), r }, {}) } function Hs(n, e) { return e.filter(t => t.attribute.rendered).map(t => t.attribute.renderHTML ? t.attribute.renderHTML(n.attrs) || {} : { [t.name]: n.attrs[t.name] }).reduce((t, r) => v(t, r), {}) } function ru(n) { return typeof n == 'function' } function T(n, e = void 0, ...t) { return ru(n) ? e ? n.bind(e)(...t) : n(...t) : n } function nh(n = {}) { return Object.keys(n).length === 0 && n.constructor === Object } function rh(n) { return typeof n != 'string' ? n : n.match(/^[+-]?(?:\d*\.)?\d+$/) ? Number(n) : n === 'true' ? !0 : n === 'false' ? !1 : n } function Ja(n, e) {
  return n.style
    ? n
    : {
        ...n,
        getAttrs: (t) => {
          const r = n.getAttrs ? n.getAttrs(t) : n.attrs; if (r === !1)
            return !1; const i = e.reduce((s, o) => { const l = o.attribute.parseHTML ? o.attribute.parseHTML(t) : rh(t.getAttribute(o.name)); return l == null ? s : { ...s, [o.name]: l } }, {}); return { ...r, ...i }
        },
      }
} function Ua(n) { return Object.fromEntries(Object.entries(n).filter(([e, t]) => e === 'attrs' && nh(t) ? !1 : t != null)) } function ih(n) { let e; const t = nu(n); const { nodeExtensions: r, markExtensions: i } = Hr(n); const s = (e = r.find(a => x(a, 'topNode'))) === null || e === void 0 ? void 0 : e.name; const o = Object.fromEntries(r.map((a) => { const u = t.filter(g => g.type === a.name); const c = { name: a.name, options: a.options, storage: a.storage }; const d = n.reduce((g, D) => { const S = x(D, 'extendNodeSchema', c); return { ...g, ...S ? S(a) : {} } }, {}); const f = Ua({ ...d, content: T(x(a, 'content', c)), marks: T(x(a, 'marks', c)), group: T(x(a, 'group', c)), inline: T(x(a, 'inline', c)), atom: T(x(a, 'atom', c)), selectable: T(x(a, 'selectable', c)), draggable: T(x(a, 'draggable', c)), code: T(x(a, 'code', c)), defining: T(x(a, 'defining', c)), isolating: T(x(a, 'isolating', c)), attrs: Object.fromEntries(u.map((g) => { let D; return [g.name, { default: (D = g == null ? void 0 : g.attribute) === null || D === void 0 ? void 0 : D.default }] })) }); const h = T(x(a, 'parseHTML', c)); h && (f.parseDOM = h.map(g => Ja(g, u))); const p = x(a, 'renderHTML', c); p && (f.toDOM = g => p({ node: g, HTMLAttributes: Hs(g, u) })); const m = x(a, 'renderText', c); return m && (f.toText = m), [a.name, f] })); const l = Object.fromEntries(i.map((a) => { const u = t.filter(m => m.type === a.name); const c = { name: a.name, options: a.options, storage: a.storage }; const d = n.reduce((m, g) => { const D = x(g, 'extendMarkSchema', c); return { ...m, ...D ? D(a) : {} } }, {}); const f = Ua({ ...d, inclusive: T(x(a, 'inclusive', c)), excludes: T(x(a, 'excludes', c)), group: T(x(a, 'group', c)), spanning: T(x(a, 'spanning', c)), code: T(x(a, 'code', c)), attrs: Object.fromEntries(u.map((m) => { let g; return [m.name, { default: (g = m == null ? void 0 : m.attribute) === null || g === void 0 ? void 0 : g.default }] })) }); const h = T(x(a, 'parseHTML', c)); h && (f.parseDOM = h.map(m => Ja(m, u))); const p = x(a, 'renderHTML', c); return p && (f.toDOM = m => p({ mark: m, HTMLAttributes: Hs(m, u) })), [a.name, f] })); return new Dr({ topNode: s, nodes: o, marks: l }) } function Rs(n, e) { return e.nodes[n] || e.marks[n] || null } function Ga(n, e) { return Array.isArray(e) ? e.some(t => (typeof t == 'string' ? t : t.name) === n.name) : e } const sh = (n, e = 500) => { let t = ''; return n.parent.nodesBetween(Math.max(0, n.parentOffset - e), n.parentOffset, (r, i, s, o) => { let l, a, u; t += ((a = (l = r.type.spec).toText) === null || a === void 0 ? void 0 : a.call(l, { node: r, pos: i, parent: s, index: o })) || ((u = n.nodeBefore) === null || u === void 0 ? void 0 : u.text) || '%leaf%' }), t }; function Ws(n) { return Object.prototype.toString.call(n) === '[object RegExp]' } const Wt = class {constructor(e) { this.find = e.find, this.handler = e.handler }}; const oh = (n, e) => {
  if (Ws(e))
    return e.exec(n); const t = e(n); if (!t)
    return null; const r = []; return r.push(t.text), r.index = t.index, r.input = n, r.data = t.data, t.replaceWith && (t.text.includes(t.replaceWith) || console.warn('[tiptap warn]: "inputRuleMatch.replaceWith" must be part of "inputRuleMatch.text".'), r.push(t.replaceWith)), r
}; function Ls(n) {
  let e; const { editor: t, from: r, to: i, text: s, rules: o, plugin: l } = n; const { view: a } = t; if (a.composing)
    return !1; const u = a.state.doc.resolve(r); if (u.parent.type.spec.code || !!(!((e = u.nodeBefore || u.nodeAfter) === null || e === void 0) && e.marks.find(f => f.type.spec.code)))
    return !1; let c = !1; const d = sh(u) + s; return o.forEach((f) => {
    if (c)
      return; const h = oh(d, f.find); if (!h)
      return; const p = a.state.tr; const m = Vr({ state: a.state, transaction: p }); const g = { from: r - (h[0].length - s.length), to: i }; const { commands: D, chain: S, can: F } = new Cn({ editor: t, state: m }); f.handler({ state: m, range: g, match: h, commands: D, chain: S, can: F }) === null || !p.steps.length || (p.setMeta(l, { transform: p, from: r, to: i, text: s }), a.dispatch(p), c = !0)
  }), c
} function lh(n) {
  const { editor: e, rules: t } = n; const r = new L({
    state: { init() { return null }, apply(i, s) { const o = i.getMeta(r); return o || (i.selectionSet || i.docChanged ? null : s) } },
    props: {
      handleTextInput(i, s, o, l) { return Ls({ editor: e, from: s, to: o, text: l, rules: t, plugin: r }) },
      handleDOMEvents: { compositionend: i => (setTimeout(() => { const { $cursor: s } = i.state.selection; s && Ls({ editor: e, from: s.pos, to: s.pos, text: '', rules: t, plugin: r }) }), !1) },
      handleKeyDown(i, s) {
        if (s.key !== 'Enter')
          return !1; const { $cursor: o } = i.state.selection; return o
          ? Ls({
            editor: e,
            from: o.pos,
            to: o.pos,
            text: `
`,
            rules: t,
            plugin: r,
          })
          : !1
      },
    },
    isInputRules: !0,
  }); return r
} function ah(n) { return typeof n == 'number' } const $s = class {constructor(e) { this.find = e.find, this.handler = e.handler }}; const uh = (n, e) => {
  if (Ws(e))
    return [...n.matchAll(e)]; const t = e(n); return t ? t.map((r) => { const i = []; return i.push(r.text), i.index = r.index, i.input = n, i.data = r.data, r.replaceWith && (r.text.includes(r.replaceWith) || console.warn('[tiptap warn]: "pasteRuleMatch.replaceWith" must be part of "pasteRuleMatch.text".'), i.push(r.replaceWith)), i }) : []
}; function ch(n) {
  const { editor: e, state: t, from: r, to: i, rule: s } = n; const { commands: o, chain: l, can: a } = new Cn({ editor: e, state: t }); const u = []; return t.doc.nodesBetween(r, i, (d, f) => {
    if (!d.isTextblock || d.type.spec.code)
      return; const h = Math.max(r, f); const p = Math.min(i, f + d.content.size); const m = d.textBetween(h - f, p - f, void 0, '\uFFFC'); uh(m, s.find).forEach((D) => {
      if (D.index === void 0)
        return; const S = h + D.index + 1; const F = S + D[0].length; const B = { from: t.tr.mapping.map(S), to: t.tr.mapping.map(F) }; const I = s.handler({ state: t, range: B, match: D, commands: o, chain: l, can: a }); u.push(I)
    })
  }), u.every(d => d !== null)
} function dh(n) {
  const { editor: e, rules: t } = n; let r = null; let i = !1; let s = !1; return t.map(l => new L({
    view(a) { const u = (c) => { let d; r = !((d = a.dom.parentElement) === null || d === void 0) && d.contains(c.target) ? a.dom.parentElement : null }; return window.addEventListener('dragstart', u), { destroy() { window.removeEventListener('dragstart', u) } } },
    props: { handleDOMEvents: { drop: a => (s = r === a.dom.parentElement, !1), paste: (a, u) => { let c; const d = (c = u.clipboardData) === null || c === void 0 ? void 0 : c.getData('text/html'); return i = !!(d != null && d.includes('data-pm-slice')), !1 } } },
    appendTransaction: (a, u, c) => {
      const d = a[0]; const f = d.getMeta('uiEvent') === 'paste' && !i; const h = d.getMeta('uiEvent') === 'drop' && !s; if (!f && !h)
        return; const p = u.doc.content.findDiffStart(c.doc.content); const m = u.doc.content.findDiffEnd(c.doc.content); if (!ah(p) || !m || p === m.b)
        return; const g = c.tr; const D = Vr({ state: c, transaction: g }); if (!(!ch({ editor: e, state: D, from: Math.max(p - 1, 0), to: m.b - 1, rule: l }) || !g.steps.length))
        return g
    },
  }))
} function fh(n) { const e = n.filter((t, r) => n.indexOf(t) !== r); return [...new Set(e)] } var Ct = class {
  constructor(e, t) { this.splittableMarks = [], this.editor = t, this.extensions = Ct.resolve(e), this.schema = ih(this.extensions), this.extensions.forEach((r) => { let i; this.editor.extensionStorage[r.name] = r.storage; const s = { name: r.name, options: r.options, storage: r.storage, editor: this.editor, type: Rs(r.name, this.schema) }; r.type === 'mark' && ((i = T(x(r, 'keepOnSplit', s))) !== null && i !== void 0 ? i : !0) && this.splittableMarks.push(r.name); const o = x(r, 'onBeforeCreate', s); o && this.editor.on('beforeCreate', o); const l = x(r, 'onCreate', s); l && this.editor.on('create', l); const a = x(r, 'onUpdate', s); a && this.editor.on('update', a); const u = x(r, 'onSelectionUpdate', s); u && this.editor.on('selectionUpdate', u); const c = x(r, 'onTransaction', s); c && this.editor.on('transaction', c); const d = x(r, 'onFocus', s); d && this.editor.on('focus', d); const f = x(r, 'onBlur', s); f && this.editor.on('blur', f); const h = x(r, 'onDestroy', s); h && this.editor.on('destroy', h) }) } static resolve(e) { const t = Ct.sort(Ct.flatten(e)); const r = fh(t.map(i => i.name)); return r.length && console.warn(`[tiptap warn]: Duplicate extension names found: [${r.map(i => `'${i}'`).join(', ')}]. This can lead to issues.`), t } static flatten(e) { return e.map((t) => { const r = { name: t.name, options: t.options, storage: t.storage }; const i = x(t, 'addExtensions', r); return i ? [t, ...this.flatten(i())] : t }).flat(10) } static sort(e) { return e.sort((r, i) => { const s = x(r, 'priority') || 100; const o = x(i, 'priority') || 100; return s > o ? -1 : s < o ? 1 : 0 }) } get commands() { return this.extensions.reduce((e, t) => { const r = { name: t.name, options: t.options, storage: t.storage, editor: this.editor, type: Rs(t.name, this.schema) }; const i = x(t, 'addCommands', r); return i ? { ...e, ...i() } : e }, {}) } get plugins() { const { editor: e } = this; const t = Ct.sort([...this.extensions].reverse()); const r = []; const i = []; const s = t.map((o) => { const l = { name: o.name, options: o.options, storage: o.storage, editor: e, type: Rs(o.name, this.schema) }; const a = []; const u = x(o, 'addKeyboardShortcuts', l); let c = {}; if (o.type === 'mark' && o.config.exitable && (c.ArrowRight = () => ie.handleExit({ editor: e, mark: o })), u) { const m = Object.fromEntries(Object.entries(u()).map(([g, D]) => [g, () => D({ editor: e })])); c = { ...c, ...m } } const d = Pa(c); a.push(d); const f = x(o, 'addInputRules', l); Ga(o, e.options.enableInputRules) && f && r.push(...f()); const h = x(o, 'addPasteRules', l); Ga(o, e.options.enablePasteRules) && h && i.push(...h()); const p = x(o, 'addProseMirrorPlugins', l); if (p) { const m = p(); a.push(...m) } return a }).flat(); return [lh({ editor: e, rules: r }), ...dh({ editor: e, rules: i }), ...s] } get attributes() { return nu(this.extensions) } get nodeViews() {
    const { editor: e } = this; const { nodeExtensions: t } = Hr(this.extensions); return Object.fromEntries(t.filter(r => !!x(r, 'addNodeView')).map((r) => {
      const i = this.attributes.filter(a => a.type === r.name); const s = { name: r.name, options: r.options, storage: r.storage, editor: e, type: G(r.name, this.schema) }; const o = x(r, 'addNodeView', s); if (!o)
        return []; const l = (a, u, c, d) => { const f = Hs(a, i); return o()({ editor: e, node: a, getPos: c, decorations: d, HTMLAttributes: f, extension: r }) }; return [r.name, l]
    }))
  }
}; function hh(n) { return Object.prototype.toString.call(n).slice(8, -1) } function zs(n) { return hh(n) !== 'Object' ? !1 : n.constructor === Object && Object.getPrototypeOf(n) === Object.prototype } function $r(n, e) { const t = { ...n }; return zs(n) && zs(e) && Object.keys(e).forEach((r) => { zs(e[r]) ? r in n ? t[r] = $r(n[r], e[r]) : Object.assign(t, { [r]: e[r] }) : Object.assign(t, { [r]: e[r] }) }), t } var H = class {constructor(e = {}) { this.type = 'extension', this.name = 'extension', this.parent = null, this.child = null, this.config = { name: this.name, defaultOptions: {} }, this.config = { ...this.config, ...e }, this.name = this.config.name, e.defaultOptions && console.warn(`[tiptap warn]: BREAKING CHANGE: "defaultOptions" is deprecated. Please use "addOptions" instead. Found in extension: "${this.name}".`), this.options = this.config.defaultOptions, this.config.addOptions && (this.options = T(x(this, 'addOptions', { name: this.name }))), this.storage = T(x(this, 'addStorage', { name: this.name, options: this.options })) || {} } static create(e = {}) { return new H(e) }configure(e = {}) { const t = this.extend(); return t.options = $r(this.options, e), t.storage = T(x(t, 'addStorage', { name: t.name, options: t.options })), t }extend(e = {}) { const t = new H(e); return t.parent = this, this.child = t, t.name = e.name ? e.name : t.parent.name, e.defaultOptions && console.warn(`[tiptap warn]: BREAKING CHANGE: "defaultOptions" is deprecated. Please use "addOptions" instead. Found in extension: "${t.name}".`), t.options = T(x(t, 'addOptions', { name: t.name })), t.storage = T(x(t, 'addStorage', { name: t.name, options: t.options })), t }}; function iu(n, e, t) {
  const { from: r, to: i } = e; const {
    blockSeparator: s = `

`, textSerializers: o = {},
  } = t || {}; let l = ''; let a = !0; return n.nodesBetween(r, i, (u, c, d, f) => { let h; const p = o == null ? void 0 : o[u.type.name]; p ? (u.isBlock && !a && (l += s, a = !0), d && (l += p({ node: u, pos: c, parent: d, index: f, range: e }))) : u.isText ? (l += (h = u == null ? void 0 : u.text) === null || h === void 0 ? void 0 : h.slice(Math.max(r, c) - c, i - c), a = !1) : u.isBlock && !a && (l += s, a = !0) }), l
} function su(n) { return Object.fromEntries(Object.entries(n.nodes).filter(([,e]) => e.spec.toText).map(([e, t]) => [e, t.spec.toText])) } const ph = H.create({ name: 'clipboardTextSerializer', addProseMirrorPlugins() { return [new L({ key: new _('clipboardTextSerializer'), props: { clipboardTextSerializer: () => { const { editor: n } = this; const { state: e, schema: t } = n; const { doc: r, selection: i } = e; const { ranges: s } = i; const o = Math.min(...s.map(c => c.$from.pos)); const l = Math.max(...s.map(c => c.$to.pos)); const a = su(t); return iu(r, { from: o, to: l }, { textSerializers: a }) } } })] } }); const mh = () => ({ editor: n, view: e }) => (requestAnimationFrame(() => { let t; n.isDestroyed || (e.dom.blur(), (t = window == null ? void 0 : window.getSelection()) === null || t === void 0 || t.removeAllRanges()) }), !0); const gh = (n = !1) => ({ commands: e }) => e.setContent('', n); const yh = () => ({ state: n, tr: e, dispatch: t }) => {
  const { selection: r } = e; const { ranges: i } = r; return t && i.forEach(({ $from: s, $to: o }) => {
    n.doc.nodesBetween(s.pos, o.pos, (l, a) => {
      if (l.type.isText)
        return; const { doc: u, mapping: c } = e; const d = u.resolve(c.map(a)); const f = u.resolve(c.map(a + l.nodeSize)); const h = d.blockRange(f); if (!h)
        return; const p = Qe(h); if (l.type.isTextblock) { const { defaultType: m } = d.parent.contentMatchAt(d.index()); e.setNodeMarkup(h.start, m) }(p || p === 0) && e.lift(h, p)
    })
  }), !0
}; const Dh = n => e => n(e); const bh = () => ({ state: n, dispatch: e }) => ws(n, e); const Ch = n => ({ tr: e, state: t, dispatch: r }) => { const i = G(n, t.schema); const s = e.selection.$anchor; for (let o = s.depth; o > 0; o -= 1) if (s.node(o).type === i) { if (r) { const a = s.before(o); const u = s.after(o); e.delete(a, u).scrollIntoView() } return !0 } return !1 }; const kh = n => ({ tr: e, dispatch: t }) => { const { from: r, to: i } = n; return t && e.delete(r, i), !0 }; const Sh = () => ({ state: n, dispatch: e }) => Pr(n, e); const xh = () => ({ commands: n }) => n.keyboardShortcut('Enter'); const Eh = () => ({ state: n, dispatch: e }) => Ns(n, e); function Lr(n, e, t = { strict: !0 }) { const r = Object.keys(e); return r.length ? r.every(i => t.strict ? e[i] === n[i] : Ws(e[i]) ? e[i].test(n[i]) : e[i] === n[i]) : !0 } function Ks(n, e, t = {}) { return n.find(r => r.type === e && Lr(r.attrs, t)) } function Ah(n, e, t = {}) { return !!Ks(n, e, t) } function qs(n, e, t = {}) {
  if (!n || !e)
    return; let r = n.parent.childAfter(n.parentOffset); if (n.parentOffset === r.offset && r.offset !== 0 && (r = n.parent.childBefore(n.parentOffset)), !r.node)
    return; const i = Ks([...r.node.marks], e, t); if (!i)
    return; let s = r.index; let o = n.start() + r.offset; let l = s + 1; let a = o + r.node.nodeSize; for (Ks([...r.node.marks], e, t); s > 0 && i.isInSet(n.parent.child(s - 1).marks);)s -= 1, o -= n.parent.child(s).nodeSize; for (;l < n.parent.childCount && Ah([...n.parent.child(l).marks], e, t);)a += n.parent.child(l).nodeSize, l += 1; return { from: o, to: a }
} function kt(n, e) {
  if (typeof n == 'string') {
    if (!e.marks[n])
      throw new Error(`There is no mark type named '${n}'. Maybe you forgot to add the extension?`); return e.marks[n]
  } return n
} const Mh = (n, e = {}) => ({ tr: t, state: r, dispatch: i }) => { const s = kt(n, r.schema); const { doc: o, selection: l } = t; const { $from: a, from: u, to: c } = l; if (i) { const d = qs(a, s, e); if (d && d.from <= u && d.to >= c) { const f = E.create(o, d.from, d.to); t.setSelection(f) } } return !0 }; const Oh = n => (e) => {
  const t = typeof n == 'function' ? n(e) : n; for (let r = 0; r < t.length; r += 1) {
    if (t[r](e))
      return !0
  } return !1
}; function Th(n) { return n instanceof E } function jt(n = 0, e = 0, t = 0) { return Math.min(Math.max(n, e), t) } function ou(n, e = null) {
  if (!e)
    return null; const t = M.atStart(n); const r = M.atEnd(n); if (e === 'start' || e === !0)
    return t; if (e === 'end')
    return r; const i = t.from; const s = r.to; return e === 'all' ? E.create(n, jt(0, i, s), jt(n.content.size, i, s)) : E.create(n, jt(e, i, s), jt(e, i, s))
} function _s() { return ['iPad Simulator', 'iPhone Simulator', 'iPod Simulator', 'iPad', 'iPhone', 'iPod'].includes(navigator.platform) || navigator.userAgent.includes('Mac') && 'ontouchend' in document } const Nh = (n = null, e = {}) => ({ editor: t, view: r, tr: i, dispatch: s }) => {
  e = { scrollIntoView: !0, ...e }; const o = () => { _s() && r.dom.focus(), requestAnimationFrame(() => { t.isDestroyed || (r.focus(), e != null && e.scrollIntoView && t.commands.scrollIntoView()) }) }; if (r.hasFocus() && n === null || n === !1)
    return !0; if (s && n === null && !Th(t.state.selection))
    return o(), !0; const l = ou(i.doc, n) || t.state.selection; const a = t.state.selection.eq(l); return s && (a || i.setSelection(l), a && i.storedMarks && i.setStoredMarks(i.storedMarks), o()), !0
}; const wh = (n, e) => t => n.every((r, i) => e(r, { ...t, index: i })); const Fh = (n, e) => ({ tr: t, commands: r }) => r.insertContentAt({ from: t.selection.from, to: t.selection.to }, n, e); function Ya(n) { const e = `<body>${n}</body>`; return new window.DOMParser().parseFromString(e, 'text/html').body } function zr(n, e, t) {
  if (t = { slice: !0, parseOptions: {}, ...t }, typeof n == 'object' && n !== null) {
    try { return Array.isArray(n) ? y.fromArray(n.map(r => e.nodeFromJSON(r))) : e.nodeFromJSON(n) }
    catch (r) { return console.warn('[tiptap warn]: Invalid content.', 'Passed value:', n, 'Error:', r), zr('', e, t) }
  } if (typeof n == 'string') { const r = Ae.fromSchema(e); return t.slice ? r.parseSlice(Ya(n), t.parseOptions).content : r.parse(Ya(n), t.parseOptions) } return zr('', e, t)
} function vh(n, e, t) {
  const r = n.steps.length - 1; if (r < e)
    return; const i = n.steps[r]; if (!(i instanceof j || i instanceof z))
    return; const s = n.mapping.maps[r]; let o = 0; s.forEach((l, a, u, c) => { o === 0 && (o = c) }), n.setSelection(M.near(n.doc.resolve(o), t))
} const Bh = n => n.toString().startsWith('<'); const Ih = (n, e, t) => ({ tr: r, dispatch: i, editor: s }) => {
  if (i) {
    t = { parseOptions: {}, updateSelection: !0, ...t }; const o = zr(e, s.schema, { parseOptions: { preserveWhitespace: 'full', ...t.parseOptions } }); if (o.toString() === '<>')
      return !0; let { from: l, to: a } = typeof n == 'number' ? { from: n, to: n } : n; let u = !0; let c = !0; if ((Bh(o) ? o : [o]).forEach((f) => { f.check(), u = u ? f.isText && f.marks.length === 0 : !1, c = c ? f.isBlock : !1 }), l === a && c) { const { parent: f } = r.doc.resolve(l); f.isTextblock && !f.type.spec.code && !f.childCount && (l -= 1, a += 1) }u ? r.insertText(e, l, a) : r.replaceWith(l, a, o), t.updateSelection && vh(r, r.steps.length - 1, -1)
  } return !0
}; const Ph = () => ({ state: n, dispatch: e }) => xs(n, e); const Rh = () => ({ state: n, dispatch: e }) => As(n, e); function lu() { return typeof navigator < 'u' ? /Mac/.test(navigator.platform) : !1 } function Lh(n) {
  const e = n.split(/-(?!$)/); let t = e[e.length - 1]; t === 'Space' && (t = ' '); let r, i, s, o; for (let l = 0; l < e.length - 1; l += 1) {
    const a = e[l]; if (/^(cmd|meta|m)$/i.test(a))
      o = !0; else if (/^a(lt)?$/i.test(a))
      r = !0; else if (/^(c|ctrl|control)$/i.test(a))
      i = !0; else if (/^s(hift)?$/i.test(a))
      s = !0; else if (/^mod$/i.test(a))
      _s() || lu() ? o = !0 : i = !0; else throw new Error(`Unrecognized modifier name: ${a}`)
  } return r && (t = `Alt-${t}`), i && (t = `Ctrl-${t}`), o && (t = `Meta-${t}`), s && (t = `Shift-${t}`), t
} const zh = n => ({ editor: e, view: t, tr: r, dispatch: i }) => { const s = Lh(n).split(/-(?!$)/); const o = s.find(u => !['Alt', 'Ctrl', 'Meta', 'Shift'].includes(u)); const l = new KeyboardEvent('keydown', { key: o === 'Space' ? ' ' : o, altKey: s.includes('Alt'), ctrlKey: s.includes('Ctrl'), metaKey: s.includes('Meta'), shiftKey: s.includes('Shift'), bubbles: !0, cancelable: !0 }); const a = e.captureTransaction(() => { t.someProp('handleKeyDown', u => u(t, l)) }); return a == null || a.steps.forEach((u) => { const c = u.map(r.mapping); c && i && r.maybeStep(c) }), !0 }; function Jn(n, e, t = {}) {
  const { from: r, to: i, empty: s } = n.selection; const o = e ? G(e, n.schema) : null; const l = []; n.doc.nodesBetween(r, i, (d, f) => {
    if (d.isText)
      return; const h = Math.max(r, f); const p = Math.min(i, f + d.nodeSize); l.push({ node: d, from: h, to: p })
  }); const a = i - r; const u = l.filter(d => o ? o.name === d.node.type.name : !0).filter(d => Lr(d.node.attrs, t, { strict: !1 })); return s ? !!u.length : u.reduce((d, f) => d + f.to - f.from, 0) >= a
} const Vh = (n, e = {}) => ({ state: t, dispatch: r }) => { const i = G(n, t.schema); return Jn(t, i, e) ? Va(t, r) : !1 }; const Hh = () => ({ state: n, dispatch: e }) => Fs(n, e); const $h = n => ({ state: e, dispatch: t }) => { const r = G(n, e.schema); return qa(r)(e, t) }; const Kh = () => ({ state: n, dispatch: e }) => Os(n, e); function Kr(n, e) { return e.nodes[n] ? 'node' : e.marks[n] ? 'mark' : null } function Qa(n, e) { const t = typeof e == 'string' ? [e] : e; return Object.keys(n).reduce((r, i) => (t.includes(i) || (r[i] = n[i]), r), {}) } const jh = (n, e) => ({ tr: t, state: r, dispatch: i }) => { let s = null; let o = null; const l = Kr(typeof n == 'string' ? n : n.name, r.schema); return l ? (l === 'node' && (s = G(n, r.schema)), l === 'mark' && (o = kt(n, r.schema)), i && t.selection.ranges.forEach((a) => { r.doc.nodesBetween(a.$from.pos, a.$to.pos, (u, c) => { s && s === u.type && t.setNodeMarkup(c, void 0, Qa(u.attrs, e)), o && u.marks.length && u.marks.forEach((d) => { o === d.type && t.addMark(c, c + u.nodeSize, o.create(Qa(d.attrs, e))) }) }) }), !0) : !1 }; const Wh = () => ({ tr: n, dispatch: e }) => (e && n.scrollIntoView(), !0); const qh = () => ({ tr: n, commands: e }) => e.setTextSelection({ from: 0, to: n.doc.content.size }); const _h = () => ({ state: n, dispatch: e }) => Es(n, e); const Jh = () => ({ state: n, dispatch: e }) => Ms(n, e); const Uh = () => ({ state: n, dispatch: e }) => Ha(n, e); const Gh = () => ({ state: n, dispatch: e }) => Bs(n, e); const Yh = () => ({ state: n, dispatch: e }) => vs(n, e); function au(n, e, t = {}) { return zr(n, e, { slice: !1, parseOptions: t }) } const Qh = (n, e = !1, t = {}) => ({ tr: r, editor: i, dispatch: s }) => { const { doc: o } = r; const l = au(n, i.schema, t); return s && r.replaceWith(0, o.content.size, l).setMeta('preventUpdate', !e), !0 }; function uu(n, e) { const t = kt(e, n.schema); const { from: r, to: i, empty: s } = n.selection; const o = []; s ? (n.storedMarks && o.push(...n.storedMarks), o.push(...n.selection.$head.marks())) : n.doc.nodesBetween(r, i, (a) => { o.push(...a.marks) }); const l = o.find(a => a.type.name === t.name); return l ? { ...l.attrs } : {} } const Xh = (n, e = {}) => ({ tr: t, state: r, dispatch: i }) => {
  const { selection: s } = t; const { empty: o, ranges: l } = s; const a = kt(n, r.schema); if (i) {
    if (o) { const u = uu(r, a); t.addStoredMark(a.create({ ...u, ...e })) }
    else { l.forEach((u) => { const c = u.$from.pos; const d = u.$to.pos; r.doc.nodesBetween(c, d, (f, h) => { const p = Math.max(h, c); const m = Math.min(h + f.nodeSize, d); f.marks.find(D => D.type === a) ? f.marks.forEach((D) => { a === D.type && t.addMark(p, m, a.create({ ...D.attrs, ...e })) }) : t.addMark(p, m, a.create(e)) }) }) }
  } return !0
}; const Zh = (n, e) => ({ tr: t }) => (t.setMeta(n, e), !0); const ep = (n, e = {}) => ({ state: t, dispatch: r, chain: i }) => { const s = G(n, t.schema); return s.isTextblock ? i().command(({ commands: o }) => Is(s, e)(t) ? !0 : o.clearNodes()).command(({ state: o }) => Is(s, e)(o, r)).run() : (console.warn('[tiptap warn]: Currently "setNode()" only supports text block nodes.'), !1) }; const tp = n => ({ tr: e, dispatch: t }) => { if (t) { const { doc: r } = e; const i = jt(n, 0, r.content.size); const s = k.create(r, i); e.setSelection(s) } return !0 }; const np = n => ({ tr: e, dispatch: t }) => { if (t) { const { doc: r } = e; const { from: i, to: s } = typeof n == 'number' ? { from: n, to: n } : n; const o = E.atStart(r).from; const l = E.atEnd(r).to; const a = jt(i, o, l); const u = jt(s, o, l); const c = E.create(r, a, u); e.setSelection(c) } return !0 }; const rp = n => ({ state: e, dispatch: t }) => { const r = G(n, e.schema); return _a(r)(e, t) }; function ip(n) {
  for (let e = 0; e < n.edgeCount; e += 1) {
    const { type: t } = n.edge(e); if (t.isTextblock && !t.hasRequiredAttrs())
      return t
  } return null
} function Rr(n, e, t) { return Object.fromEntries(Object.entries(t).filter(([r]) => { const i = n.find(s => s.type === e && s.name === r); return i ? i.attribute.keepOnSplit : !1 })) } function Xa(n, e) { const t = n.storedMarks || n.selection.$to.parentOffset && n.selection.$from.marks(); if (t) { const r = t.filter(i => e == null ? void 0 : e.includes(i.type.name)); n.tr.ensureMarks(r) } } const sp = ({ keepMarks: n = !0 } = {}) => ({ tr: e, state: t, dispatch: r, editor: i }) => {
  const { selection: s, doc: o } = e; const { $from: l, $to: a } = s; const u = i.extensionManager.attributes; const c = Rr(u, l.node().type.name, l.node().attrs); if (s instanceof k && s.node.isBlock)
    return !l.parentOffset || !Oe(o, l.pos) ? !1 : (r && (n && Xa(t, i.extensionManager.splittableMarks), e.split(l.pos).scrollIntoView()), !0); if (!l.parent.isBlock)
    return !1; if (r) { const d = a.parentOffset === a.parent.content.size; s instanceof E && e.deleteSelection(); const f = l.depth === 0 ? void 0 : ip(l.node(-1).contentMatchAt(l.indexAfter(-1))); let h = d && f ? [{ type: f, attrs: c }] : void 0; let p = Oe(e.doc, e.mapping.map(l.pos), 1, h); if (!h && !p && Oe(e.doc, e.mapping.map(l.pos), 1, f ? [{ type: f }] : void 0) && (p = !0, h = f ? [{ type: f, attrs: c }] : void 0), p && (e.split(e.mapping.map(l.pos), 1, h), f && !d && !l.parentOffset && l.parent.type !== f)) { const m = e.mapping.map(l.before()); const g = e.doc.resolve(m); l.node(-1).canReplaceWith(g.index(), g.index() + 1, f) && e.setNodeMarkup(e.mapping.map(l.before()), f) }n && Xa(t, i.extensionManager.splittableMarks), e.scrollIntoView() } return !0
}; const op = n => ({ tr: e, state: t, dispatch: r, editor: i }) => {
  let s; const o = G(n, t.schema); const { $from: l, $to: a } = t.selection; const u = t.selection.node; if (u && u.isBlock || l.depth < 2 || !l.sameParent(a))
    return !1; const c = l.node(-1); if (c.type !== o)
    return !1; const d = i.extensionManager.attributes; if (l.parent.content.size === 0 && l.node(-1).childCount === l.indexAfter(-1)) {
    if (l.depth === 2 || l.node(-3).type !== o || l.index(-2) !== l.node(-2).childCount - 1)
      return !1; if (r) {
      let g = y.empty; const D = l.index(-1) ? 1 : l.index(-2) ? 2 : 3; for (let Q = l.depth - D; Q >= l.depth - 3; Q -= 1)g = y.from(l.node(Q).copy(g)); const S = l.indexAfter(-1) < l.node(-2).childCount ? 1 : l.indexAfter(-2) < l.node(-3).childCount ? 2 : 3; const F = Rr(d, l.node().type.name, l.node().attrs); const B = ((s = o.contentMatch.defaultType) === null || s === void 0 ? void 0 : s.createAndFill(F)) || void 0; g = g.append(y.from(o.createAndFill(null, B) || void 0)); const I = l.before(l.depth - (D - 1)); e.replace(I, l.after(-S), new b(g, 4 - D, 0)); let fe = -1; e.doc.nodesBetween(I, e.doc.content.size, (Q, O) => {
        if (fe > -1)
          return !1; Q.isTextblock && Q.content.size === 0 && (fe = O + 1)
      }), fe > -1 && e.setSelection(E.near(e.doc.resolve(fe))), e.scrollIntoView()
    } return !0
  } const f = a.pos === l.end() ? c.contentMatchAt(0).defaultType : null; const h = Rr(d, c.type.name, c.attrs); const p = Rr(d, l.node().type.name, l.node().attrs); e.delete(l.pos, a.pos); const m = f ? [{ type: o, attrs: h }, { type: f, attrs: p }] : [{ type: o, attrs: h }]; return Oe(e.doc, l.pos, 2) ? (r && e.split(l.pos, 2, m).scrollIntoView(), !0) : !1
}; function lp(n, e) {
  for (let t = n.depth; t > 0; t -= 1) {
    const r = n.node(t); if (e(r))
      return { pos: t > 0 ? n.before(t) : 0, start: n.start(t), depth: t, node: r }
  }
} function Js(n) { return e => lp(e.$from, n) } function Za(n, e) {
  const { nodeExtensions: t } = Hr(e); const r = t.find(o => o.name === n); if (!r)
    return !1; const i = { name: r.name, options: r.options, storage: r.storage }; const s = T(x(r, 'group', i)); return typeof s != 'string' ? !1 : s.split(' ').includes('list')
} const eu = (n, e) => {
  const t = Js(o => o.type === e)(n.selection); if (!t)
    return !0; const r = n.doc.resolve(Math.max(0, t.pos - 1)).before(t.depth); if (r === void 0)
    return !0; const i = n.doc.nodeAt(r); return t.node.type === (i == null ? void 0 : i.type) && Pt(n.doc, t.pos) && n.join(t.pos), !0
}; const tu = (n, e) => {
  const t = Js(o => o.type === e)(n.selection); if (!t)
    return !0; const r = n.doc.resolve(t.start).after(t.depth); if (r === void 0)
    return !0; const i = n.doc.nodeAt(r); return t.node.type === (i == null ? void 0 : i.type) && Pt(n.doc, r) && n.join(r), !0
}; const ap = (n, e) => ({ editor: t, tr: r, state: i, dispatch: s, chain: o, commands: l, can: a }) => {
  const { extensions: u } = t.extensionManager; const c = G(n, i.schema); const d = G(e, i.schema); const { selection: f } = i; const { $from: h, $to: p } = f; const m = h.blockRange(p); if (!m)
    return !1; const g = Js(D => Za(D.type.name, u))(f); if (m.depth >= 1 && g && m.depth - g.depth <= 1) {
    if (g.node.type === c)
      return l.liftListItem(d); if (Za(g.node.type.name, u) && c.validContent(g.node.content) && s)
      return o().command(() => (r.setNodeMarkup(g.pos, c), !0)).command(() => eu(r, c)).command(() => tu(r, c)).run()
  } return o().command(() => a().wrapInList(c) ? !0 : l.clearNodes()).wrapInList(c).command(() => eu(r, c)).command(() => tu(r, c)).run()
}; function js(n, e, t = {}) {
  const { empty: r, ranges: i } = n.selection; const s = e ? kt(e, n.schema) : null; if (r)
    return !!(n.storedMarks || n.selection.$from.marks()).filter(d => s ? s.name === d.type.name : !0).find(d => Lr(d.attrs, t, { strict: !1 })); let o = 0; const l = []; if (i.forEach(({ $from: d, $to: f }) => {
    const h = d.pos; const p = f.pos; n.doc.nodesBetween(h, p, (m, g) => {
      if (!m.isText && !m.marks.length)
        return; const D = Math.max(h, g); const S = Math.min(p, g + m.nodeSize); o += S - D, l.push(...m.marks.map(B => ({ mark: B, from: D, to: S })))
    })
  }), o === 0)
    return !1; const a = l.filter(d => s ? s.name === d.mark.type.name : !0).filter(d => Lr(d.mark.attrs, t, { strict: !1 })).reduce((d, f) => d + f.to - f.from, 0); const u = l.filter(d => s ? d.mark.type !== s && d.mark.type.excludes(s) : !0).reduce((d, f) => d + f.to - f.from, 0); return (a > 0 ? a + u : a) >= o
} const up = (n, e = {}, t = {}) => ({ state: r, commands: i }) => { const { extendEmptyMarkRange: s = !1 } = t; const o = kt(n, r.schema); return js(r, o, e) ? i.unsetMark(o, { extendEmptyMarkRange: s }) : i.setMark(o, e) }; const cp = (n, e, t = {}) => ({ state: r, commands: i }) => { const s = G(n, r.schema); const o = G(e, r.schema); return Jn(r, s, t) ? i.setNode(o) : i.setNode(s, t) }; const dp = (n, e = {}) => ({ state: t, commands: r }) => { const i = G(n, t.schema); return Jn(t, i, e) ? r.lift(i) : r.wrapIn(i, e) }; const fp = () => ({ state: n, dispatch: e }) => {
  const t = n.plugins; for (let r = 0; r < t.length; r += 1) {
    const i = t[r]; let s; if (i.spec.isInputRules && (s = i.getState(n))) {
      if (e) {
        const o = n.tr; const l = s.transform; for (let a = l.steps.length - 1; a >= 0; a -= 1)o.step(l.steps[a].invert(l.docs[a])); if (s.text) { const a = o.doc.resolve(s.from).marks(); o.replaceWith(s.from, s.to, n.schema.text(s.text, a)) }
        else { o.delete(s.from, s.to) }
      } return !0
    }
  } return !1
}; const hp = () => ({ tr: n, dispatch: e }) => { const { selection: t } = n; const { empty: r, ranges: i } = t; return r || e && i.forEach((s) => { n.removeMark(s.$from.pos, s.$to.pos) }), !0 }; const pp = (n, e = {}) => ({ tr: t, state: r, dispatch: i }) => {
  let s; const { extendEmptyMarkRange: o = !1 } = e; const { selection: l } = t; const a = kt(n, r.schema); const { $from: u, empty: c, ranges: d } = l; if (!i)
    return !0; if (c && o) { let { from: f, to: h } = l; const p = (s = u.marks().find(g => g.type === a)) === null || s === void 0 ? void 0 : s.attrs; const m = qs(u, a, p); m && (f = m.from, h = m.to), t.removeMark(f, h, a) }
  else { d.forEach((f) => { t.removeMark(f.$from.pos, f.$to.pos, a) }) } return t.removeStoredMark(a), !0
}; const mp = (n, e = {}) => ({ tr: t, state: r, dispatch: i }) => { let s = null; let o = null; const l = Kr(typeof n == 'string' ? n : n.name, r.schema); return l ? (l === 'node' && (s = G(n, r.schema)), l === 'mark' && (o = kt(n, r.schema)), i && t.selection.ranges.forEach((a) => { const u = a.$from.pos; const c = a.$to.pos; r.doc.nodesBetween(u, c, (d, f) => { s && s === d.type && t.setNodeMarkup(f, void 0, { ...d.attrs, ...e }), o && d.marks.length && d.marks.forEach((h) => { if (o === h.type) { const p = Math.max(f, u); const m = Math.min(f + d.nodeSize, c); t.addMark(p, m, o.create({ ...h.attrs, ...e })) } }) }) }), !0) : !1 }; const gp = (n, e = {}) => ({ state: t, dispatch: r }) => { const i = G(n, t.schema); return ja(i, e)(t, r) }; const yp = (n, e = {}) => ({ state: t, dispatch: r }) => { const i = G(n, t.schema); return Wa(i, e)(t, r) }; const Dp = Object.freeze({ __proto__: null, blur: mh, clearContent: gh, clearNodes: yh, command: Dh, createParagraphNear: bh, deleteNode: Ch, deleteRange: kh, deleteSelection: Sh, enter: xh, exitCode: Eh, extendMarkRange: Mh, first: Oh, focus: Nh, forEach: wh, insertContent: Fh, insertContentAt: Ih, joinBackward: Ph, joinForward: Rh, keyboardShortcut: zh, lift: Vh, liftEmptyBlock: Hh, liftListItem: $h, newlineInCode: Kh, resetAttributes: jh, scrollIntoView: Wh, selectAll: qh, selectNodeBackward: _h, selectNodeForward: Jh, selectParentNode: Uh, selectTextblockEnd: Gh, selectTextblockStart: Yh, setContent: Qh, setMark: Xh, setMeta: Zh, setNode: ep, setNodeSelection: tp, setTextSelection: np, sinkListItem: rp, splitBlock: sp, splitListItem: op, toggleList: ap, toggleMark: up, toggleNode: cp, toggleWrap: dp, undoInputRule: fp, unsetAllMarks: hp, unsetMark: pp, updateAttributes: mp, wrapIn: gp, wrapInList: yp }); const bp = H.create({ name: 'commands', addCommands() { return { ...Dp } } }); const Cp = H.create({ name: 'editable', addProseMirrorPlugins() { return [new L({ key: new _('editable'), props: { editable: () => this.editor.options.editable } })] } }); const kp = H.create({ name: 'focusEvents', addProseMirrorPlugins() { const { editor: n } = this; return [new L({ key: new _('focusEvents'), props: { handleDOMEvents: { focus: (e, t) => { n.isFocused = !0; const r = n.state.tr.setMeta('focus', { event: t }).setMeta('addToHistory', !1); return e.dispatch(r), !1 }, blur: (e, t) => { n.isFocused = !1; const r = n.state.tr.setMeta('blur', { event: t }).setMeta('addToHistory', !1); return e.dispatch(r), !1 } } } })] } }); const Sp = H.create({
  name: 'keymap',
  addKeyboardShortcuts() { const n = () => this.editor.commands.first(({ commands: o }) => [() => o.undoInputRule(), () => o.command(({ tr: l }) => { const { selection: a, doc: u } = l; const { empty: c, $anchor: d } = a; const { pos: f, parent: h } = d; const p = M.atStart(u).from === f; return !c || !p || !h.type.isTextblock || h.textContent.length ? !1 : o.clearNodes() }), () => o.deleteSelection(), () => o.joinBackward(), () => o.selectNodeBackward()]); const e = () => this.editor.commands.first(({ commands: o }) => [() => o.deleteSelection(), () => o.joinForward(), () => o.selectNodeForward()]); const r = { 'Enter': () => this.editor.commands.first(({ commands: o }) => [() => o.newlineInCode(), () => o.createParagraphNear(), () => o.liftEmptyBlock(), () => o.splitBlock()]), 'Mod-Enter': () => this.editor.commands.exitCode(), 'Backspace': n, 'Mod-Backspace': n, 'Shift-Backspace': n, 'Delete': e, 'Mod-Delete': e, 'Mod-a': () => this.editor.commands.selectAll() }; const i = { ...r }; const s = { ...r, 'Ctrl-h': n, 'Alt-Backspace': n, 'Ctrl-d': e, 'Ctrl-Alt-Backspace': e, 'Alt-Delete': e, 'Alt-d': e, 'Ctrl-a': () => this.editor.commands.selectTextblockStart(), 'Ctrl-e': () => this.editor.commands.selectTextblockEnd() }; return _s() || lu() ? s : i },
  addProseMirrorPlugins() {
    return [new L({
      key: new _('clearDocument'),
      appendTransaction: (n, e, t) => {
        if (!(n.some(p => p.docChanged) && !e.doc.eq(t.doc)))
          return; const { empty: i, from: s, to: o } = e.selection; const l = M.atStart(e.doc).from; const a = M.atEnd(e.doc).to; const u = s === l && o === a; const c = t.doc.textBetween(0, t.doc.content.size, ' ', ' ').length === 0; if (i || !u || !c)
          return; const d = t.tr; const f = Vr({ state: t, transaction: d }); const { commands: h } = new Cn({ editor: this.editor, state: f }); if (h.clearNodes(), !!d.steps.length)
          return d
      },
    })]
  },
}); const xp = H.create({ name: 'tabindex', addProseMirrorPlugins() { return [new L({ key: new _('tabindex'), props: { attributes: this.editor.isEditable ? { tabindex: '0' } : {} } })] } }); const Ep = Object.freeze({ __proto__: null, ClipboardTextSerializer: ph, Commands: bp, Editable: Cp, FocusEvents: kp, Keymap: Sp, Tabindex: xp }); function Ap(n, e) { const t = G(e, n.schema); const { from: r, to: i } = n.selection; const s = []; n.doc.nodesBetween(r, i, (l) => { s.push(l) }); const o = s.reverse().find(l => l.type.name === t.name); return o ? { ...o.attrs } : {} } function Us(n, e) { const t = Kr(typeof e == 'string' ? e : e.name, n.schema); return t === 'node' ? Ap(n, e) : t === 'mark' ? uu(n, e) : {} } function Mp(n, e) { const t = X.fromSchema(e).serializeFragment(n); const i = document.implementation.createHTMLDocument().createElement('div'); return i.appendChild(t), i.innerHTML } function Op(n, e) { const t = { from: 0, to: n.content.size }; return iu(n, t, e) } function Tp(n, e, t = {}) {
  if (!e)
    return Jn(n, null, t) || js(n, null, t); const r = Kr(e, n.schema); return r === 'node' ? Jn(n, e, t) : r === 'mark' ? js(n, e, t) : !1
} function Np(n) { let e; const t = (e = n.type.createAndFill()) === null || e === void 0 ? void 0 : e.toJSON(); const r = n.toJSON(); return JSON.stringify(t) === JSON.stringify(r) } const wp = `.ProseMirror {
  position: relative;
}

.ProseMirror {
  word-wrap: break-word;
  white-space: pre-wrap;
  white-space: break-spaces;
  -webkit-font-variant-ligatures: none;
  font-variant-ligatures: none;
  font-feature-settings: "liga" 0; /* the above doesn't seem to work in Edge */
}

.ProseMirror [contenteditable="false"] {
  white-space: normal;
}

.ProseMirror [contenteditable="false"] [contenteditable="true"] {
  white-space: pre-wrap;
}

.ProseMirror pre {
  white-space: pre-wrap;
}

img.ProseMirror-separator {
  display: inline !important;
  border: none !important;
  margin: 0 !important;
  width: 1px !important;
  height: 1px !important;
}

.ProseMirror-gapcursor {
  display: none;
  pointer-events: none;
  position: absolute;
  margin: 0;
}

.ProseMirror-gapcursor:after {
  content: "";
  display: block;
  position: absolute;
  top: -2px;
  width: 20px;
  border-top: 1px solid black;
  animation: ProseMirror-cursor-blink 1.1s steps(2, start) infinite;
}

@keyframes ProseMirror-cursor-blink {
  to {
    visibility: hidden;
  }
}

.ProseMirror-hideselection *::selection {
  background: transparent;
}

.ProseMirror-hideselection *::-moz-selection {
  background: transparent;
}

.ProseMirror-hideselection * {
  caret-color: transparent;
}

.ProseMirror-focused .ProseMirror-gapcursor {
  display: block;
}

.tippy-box[data-animation=fade][data-state=hidden] {
  opacity: 0
}`;function Fp(n, e) {
  const t = document.querySelector('style[data-tiptap-style]'); if (t !== null)
    return t; const r = document.createElement('style'); return e && r.setAttribute('nonce', e), r.setAttribute('data-tiptap-style', ''), r.innerHTML = n, document.getElementsByTagName('head')[0].appendChild(r), r
} var Un = class extends Vs {
  constructor(e = {}) { super(), this.isFocused = !1, this.extensionStorage = {}, this.options = { element: document.createElement('div'), content: '', injectCSS: !0, injectNonce: void 0, extensions: [], autofocus: !1, editable: !0, editorProps: {}, parseOptions: {}, enableInputRules: !0, enablePasteRules: !0, enableCoreExtensions: !0, onBeforeCreate: () => null, onCreate: () => null, onUpdate: () => null, onSelectionUpdate: () => null, onTransaction: () => null, onFocus: () => null, onBlur: () => null, onDestroy: () => null }, this.isCapturingTransaction = !1, this.capturedTransaction = null, this.setOptions(e), this.createExtensionManager(), this.createCommandManager(), this.createSchema(), this.on('beforeCreate', this.options.onBeforeCreate), this.emit('beforeCreate', { editor: this }), this.createView(), this.injectCSS(), this.on('create', this.options.onCreate), this.on('update', this.options.onUpdate), this.on('selectionUpdate', this.options.onSelectionUpdate), this.on('transaction', this.options.onTransaction), this.on('focus', this.options.onFocus), this.on('blur', this.options.onBlur), this.on('destroy', this.options.onDestroy), window.setTimeout(() => { this.isDestroyed || (this.commands.focus(this.options.autofocus), this.emit('create', { editor: this })) }, 0) } get storage() { return this.extensionStorage } get commands() { return this.commandManager.commands }chain() { return this.commandManager.chain() }can() { return this.commandManager.can() }injectCSS() { this.options.injectCSS && document && (this.css = Fp(wp, this.options.injectNonce)) }setOptions(e = {}) { this.options = { ...this.options, ...e }, !(!this.view || !this.state || this.isDestroyed) && (this.options.editorProps && this.view.setProps(this.options.editorProps), this.view.updateState(this.state)) }setEditable(e) { this.setOptions({ editable: e }), this.emit('update', { editor: this, transaction: this.state.tr }) } get isEditable() { return this.options.editable && this.view && this.view.editable } get state() { return this.view.state }registerPlugin(e, t) { const r = ru(t) ? t(e, [...this.state.plugins]) : [...this.state.plugins, e]; const i = this.state.reconfigure({ plugins: r }); this.view.updateState(i) }unregisterPlugin(e) {
    if (this.isDestroyed)
      return; const t = typeof e == 'string' ? `${e}$` : e.key; const r = this.state.reconfigure({ plugins: this.state.plugins.filter(i => !i.key.startsWith(t)) }); this.view.updateState(r)
  }

  createExtensionManager() { const t = [...this.options.enableCoreExtensions ? Object.values(Ep) : [], ...this.options.extensions].filter(r => ['extension', 'node', 'mark'].includes(r == null ? void 0 : r.type)); this.extensionManager = new Ct(t, this) }createCommandManager() { this.commandManager = new Cn({ editor: this }) }createSchema() { this.schema = this.extensionManager.schema }createView() { const e = au(this.options.content, this.schema, this.options.parseOptions); const t = ou(e, this.options.autofocus); this.view = new wr(this.options.element, { ...this.options.editorProps, dispatchTransaction: this.dispatchTransaction.bind(this), state: Xe.create({ doc: e, selection: t || void 0 }) }); const r = this.state.reconfigure({ plugins: this.extensionManager.plugins }); this.view.updateState(r), this.createNodeViews(); const i = this.view.dom; i.editor = this }createNodeViews() { this.view.setProps({ nodeViews: this.extensionManager.nodeViews }) }captureTransaction(e) { this.isCapturingTransaction = !0, e(), this.isCapturingTransaction = !1; const t = this.capturedTransaction; return this.capturedTransaction = null, t }dispatchTransaction(e) { if (this.isCapturingTransaction) { if (!this.capturedTransaction) { this.capturedTransaction = e; return }e.steps.forEach((o) => { let l; return (l = this.capturedTransaction) === null || l === void 0 ? void 0 : l.step(o) }); return } const t = this.state.apply(e); const r = !this.state.selection.eq(t.selection); this.view.updateState(t), this.emit('transaction', { editor: this, transaction: e }), r && this.emit('selectionUpdate', { editor: this, transaction: e }); const i = e.getMeta('focus'); const s = e.getMeta('blur'); i && this.emit('focus', { editor: this, event: i.event, transaction: e }), s && this.emit('blur', { editor: this, event: s.event, transaction: e }), !(!e.docChanged || e.getMeta('preventUpdate')) && this.emit('update', { editor: this, transaction: e }) }getAttributes(e) { return Us(this.state, e) }isActive(e, t) { const r = typeof e == 'string' ? e : null; const i = typeof e == 'string' ? t : e; return Tp(this.state, r, i) }getJSON() { return this.state.doc.toJSON() }getHTML() { return Mp(this.state.doc.content, this.schema) }getText(e) {
    const {
      blockSeparator: t = `

`, textSerializers: r = {},
    } = e || {}; return Op(this.state.doc, { blockSeparator: t, textSerializers: { ...r, ...su(this.schema) } })
  }

  get isEmpty() { return Np(this.state.doc) }getCharacterCount() { return console.warn('[tiptap warn]: "editor.getCharacterCount()" is deprecated. Please use "editor.storage.characterCount.characters()" instead.'), this.state.doc.content.size - 2 }destroy() { this.emit('destroy'), this.view && this.view.destroy(), this.removeAllListeners() } get isDestroyed() { let e; return !(!((e = this.view) === null || e === void 0) && e.docView) }
}; function cu(n, e) { const t = new ln(n); return e.forEach((r) => { r.steps.forEach((i) => { t.step(i) }) }), t } function du(n, e, t) { const r = []; return n.nodesBetween(e.from, e.to, (i, s) => { t(i) && r.push({ node: i, pos: s }) }), r } function vp(n, e = JSON.stringify) { const t = {}; return n.filter((r) => { const i = e(r); return Object.prototype.hasOwnProperty.call(t, i) ? !1 : t[i] = !0 }) } function Bp(n) { const e = vp(n); return e.length === 1 ? e : e.filter((t, r) => !e.filter((s, o) => o !== r).some(s => t.oldRange.from >= s.oldRange.from && t.oldRange.to <= s.oldRange.to && t.newRange.from >= s.newRange.from && t.newRange.to <= s.newRange.to)) } function fu(n) {
  const { mapping: e, steps: t } = n; const r = []; return e.maps.forEach((i, s) => {
    const o = []; if (i.ranges.length) { i.forEach((l, a) => { o.push({ from: l, to: a }) }) }
    else {
      const { from: l, to: a } = t[s]; if (l === void 0 || a === void 0)
        return; o.push({ from: l, to: a })
    }o.forEach(({ from: l, to: a }) => { const u = e.slice(s).map(l, -1); const c = e.slice(s).map(a); const d = e.invert().map(u, -1); const f = e.invert().map(c); r.push({ oldRange: { from: d, to: f }, newRange: { from: u, to: c } }) })
  }), Bp(r)
} function Gn(n, e, t) { const r = []; return n === e ? t.resolve(n).marks().forEach((i) => { const s = t.resolve(n - 1); const o = qs(s, i.type); !o || r.push({ mark: i, ...o }) }) : t.nodesBetween(n, e, (i, s) => { r.push(...i.marks.map(o => ({ from: s, to: s + i.nodeSize, mark: o }))) }), r } function qe(n) {
  return new Wt({
    find: n.find,
    handler: ({ state: e, range: t, match: r }) => {
      const i = T(n.getAttributes, void 0, r); if (i === !1 || i === null)
        return null; const { tr: s } = e; const o = r[r.length - 1]; const l = r[0]; let a = t.to; if (o) {
        const u = l.search(/\S/); const c = t.from + l.indexOf(o); const d = c + o.length; if (Gn(t.from, t.to, e.doc).filter(h => h.mark.type.excluded.find(m => m === n.type && m !== h.mark.type)).filter(h => h.to > c).length)
          return null; d < t.to && s.delete(d, t.to), c > t.from && s.delete(t.from + u, c), a = t.from + u + o.length, s.addMark(t.from + u, a, n.type.create(i || {})), s.removeStoredMark(n.type)
      }
    },
  })
} function hu(n) {
  return new Wt({
    find: n.find,
    handler: ({ state: e, range: t, match: r }) => {
      const i = T(n.getAttributes, void 0, r) || {}; const { tr: s } = e; const o = t.from; let l = t.to; if (r[1]) { const a = r[0].lastIndexOf(r[1]); let u = o + a; u > l ? u = l : l = u + r[1].length; const c = r[0][r[0].length - 1]; s.insertText(c, o + r[0].length - 1), s.replaceWith(u, l, n.type.create(i)) }
      else { r[0] && s.replaceWith(o, l, n.type.create(i)) }
    },
  })
} function Yn(n) {
  return new Wt({
    find: n.find,
    handler: ({ state: e, range: t, match: r }) => {
      const i = e.doc.resolve(t.from); const s = T(n.getAttributes, void 0, r) || {}; if (!i.node(-1).canReplaceWith(i.index(-1), i.indexAfter(-1), n.type))
        return null; e.tr.delete(t.from, t.to).setBlockType(t.from, t.from, n.type, s)
    },
  })
} function $(n) { return new Wt({ find: n.find, handler: ({ state: e, range: t, match: r }) => { let i = n.replace; let s = t.from; const o = t.to; if (r[1]) { const l = r[0].lastIndexOf(r[1]); i += r[0].slice(l + r[1].length), s += l; const a = s - o; a > 0 && (i = r[0].slice(l - a, l) + i, s = o) }e.tr.insertText(i, s, o) } }) } function kn(n) {
  return new Wt({
    find: n.find,
    handler: ({ state: e, range: t, match: r }) => {
      const i = T(n.getAttributes, void 0, r) || {}; const s = e.tr.delete(t.from, t.to); const l = s.doc.resolve(t.from).blockRange(); const a = l && an(l, n.type, i); if (!a)
        return null; s.wrap(l, a); const u = s.doc.resolve(t.from - 1).nodeBefore; u && u.type === n.type && Pt(s.doc, t.from - 1) && (!n.joinPredicate || n.joinPredicate(r, u)) && s.join(t.from - 1)
    },
  })
} var ie = class {
  constructor(e = {}) { this.type = 'mark', this.name = 'mark', this.parent = null, this.child = null, this.config = { name: this.name, defaultOptions: {} }, this.config = { ...this.config, ...e }, this.name = this.config.name, e.defaultOptions && console.warn(`[tiptap warn]: BREAKING CHANGE: "defaultOptions" is deprecated. Please use "addOptions" instead. Found in extension: "${this.name}".`), this.options = this.config.defaultOptions, this.config.addOptions && (this.options = T(x(this, 'addOptions', { name: this.name }))), this.storage = T(x(this, 'addStorage', { name: this.name, options: this.options })) || {} } static create(e = {}) { return new ie(e) }configure(e = {}) { const t = this.extend(); return t.options = $r(this.options, e), t.storage = T(x(t, 'addStorage', { name: t.name, options: t.options })), t }extend(e = {}) { const t = new ie(e); return t.parent = this, this.child = t, t.name = e.name ? e.name : t.parent.name, e.defaultOptions && console.warn(`[tiptap warn]: BREAKING CHANGE: "defaultOptions" is deprecated. Please use "addOptions" instead. Found in extension: "${t.name}".`), t.options = T(x(t, 'addOptions', { name: t.name })), t.storage = T(x(t, 'addStorage', { name: t.name, options: t.options })), t } static handleExit({ editor: e, mark: t }) {
    const { tr: r } = e.state; const i = e.state.selection.$from; if (i.pos === i.end()) {
      const o = i.marks(); if (!o.find(u => (u == null ? void 0 : u.type.name) === t.name))
        return !1; const a = o.find(u => (u == null ? void 0 : u.type.name) === t.name); return a && r.removeStoredMark(a), r.insertText(' ', i.pos), e.view.dispatch(r), !0
    } return !1
  }
}; var R = class {constructor(e = {}) { this.type = 'node', this.name = 'node', this.parent = null, this.child = null, this.config = { name: this.name, defaultOptions: {} }, this.config = { ...this.config, ...e }, this.name = this.config.name, e.defaultOptions && console.warn(`[tiptap warn]: BREAKING CHANGE: "defaultOptions" is deprecated. Please use "addOptions" instead. Found in extension: "${this.name}".`), this.options = this.config.defaultOptions, this.config.addOptions && (this.options = T(x(this, 'addOptions', { name: this.name }))), this.storage = T(x(this, 'addStorage', { name: this.name, options: this.options })) || {} } static create(e = {}) { return new R(e) }configure(e = {}) { const t = this.extend(); return t.options = $r(this.options, e), t.storage = T(x(t, 'addStorage', { name: t.name, options: t.options })), t }extend(e = {}) { const t = new R(e); return t.parent = this, this.child = t, t.name = e.name ? e.name : t.parent.name, e.defaultOptions && console.warn(`[tiptap warn]: BREAKING CHANGE: "defaultOptions" is deprecated. Please use "addOptions" instead. Found in extension: "${t.name}".`), t.options = T(x(t, 'addOptions', { name: t.name })), t.storage = T(x(t, 'addStorage', { name: t.name, options: t.options })), t }}; function Ne(n) {
  return new $s({
    find: n.find,
    handler: ({ state: e, range: t, match: r }) => {
      const i = T(n.getAttributes, void 0, r); if (i === !1 || i === null)
        return null; const { tr: s } = e; const o = r[r.length - 1]; const l = r[0]; let a = t.to; if (o) {
        const u = l.search(/\S/); const c = t.from + l.indexOf(o); const d = c + o.length; if (Gn(t.from, t.to, e.doc).filter(h => h.mark.type.excluded.find(m => m === n.type && m !== h.mark.type)).filter(h => h.to > c).length)
          return null; d < t.to && s.delete(d, t.to), c > t.from && s.delete(t.from + u, c), a = t.from + u + o.length, s.addMark(t.from + u, a, n.type.create(i || {})), s.removeStoredMark(n.type)
      }
    },
  })
} const Ip = /^\s*>\s$/; const pu = R.create({ name: 'blockquote', addOptions() { return { HTMLAttributes: {} } }, content: 'block+', group: 'block', defining: !0, parseHTML() { return [{ tag: 'blockquote' }] }, renderHTML({ HTMLAttributes: n }) { return ['blockquote', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setBlockquote: () => ({ commands: n }) => n.wrapIn(this.name), toggleBlockquote: () => ({ commands: n }) => n.toggleWrap(this.name), unsetBlockquote: () => ({ commands: n }) => n.lift(this.name) } }, addKeyboardShortcuts() { return { 'Mod-Shift-b': () => this.editor.commands.toggleBlockquote() } }, addInputRules() { return [kn({ find: Ip, type: this.type })] } }); const Pp = /(?:^|\s)((?:\*\*)((?:[^*]+))(?:\*\*))$/; const Rp = /(?:^|\s)((?:\*\*)((?:[^*]+))(?:\*\*))/g; const Lp = /(?:^|\s)((?:__)((?:[^__]+))(?:__))$/; const zp = /(?:^|\s)((?:__)((?:[^__]+))(?:__))/g; const mu = ie.create({ name: 'bold', addOptions() { return { HTMLAttributes: {} } }, parseHTML() { return [{ tag: 'strong' }, { tag: 'b', getAttrs: n => n.style.fontWeight !== 'normal' && null }, { style: 'font-weight', getAttrs: n => /^(bold(er)?|[5-9]\d{2,})$/.test(n) && null }] }, renderHTML({ HTMLAttributes: n }) { return ['strong', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setBold: () => ({ commands: n }) => n.setMark(this.name), toggleBold: () => ({ commands: n }) => n.toggleMark(this.name), unsetBold: () => ({ commands: n }) => n.unsetMark(this.name) } }, addKeyboardShortcuts() { return { 'Mod-b': () => this.editor.commands.toggleBold(), 'Mod-B': () => this.editor.commands.toggleBold() } }, addInputRules() { return [qe({ find: Pp, type: this.type }), qe({ find: Lp, type: this.type })] }, addPasteRules() { return [Ne({ find: Rp, type: this.type }), Ne({ find: zp, type: this.type })] } }); const Vp = /^\s*([-+*])\s$/; const gu = R.create({ name: 'bulletList', addOptions() { return { itemTypeName: 'listItem', HTMLAttributes: {} } }, group: 'block list', content() { return `${this.options.itemTypeName}+` }, parseHTML() { return [{ tag: 'ul' }] }, renderHTML({ HTMLAttributes: n }) { return ['ul', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { toggleBulletList: () => ({ commands: n }) => n.toggleList(this.name, this.options.itemTypeName) } }, addKeyboardShortcuts() { return { 'Mod-Shift-8': () => this.editor.commands.toggleBulletList() } }, addInputRules() { return [kn({ find: Vp, type: this.type })] } }); const Hp = /(?:^|\s)((?:`)((?:[^`]+))(?:`))$/; const $p = /(?:^|\s)((?:`)((?:[^`]+))(?:`))/g; const yu = ie.create({ name: 'code', addOptions() { return { HTMLAttributes: {} } }, excludes: '_', code: !0, exitable: !0, parseHTML() { return [{ tag: 'code' }] }, renderHTML({ HTMLAttributes: n }) { return ['code', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setCode: () => ({ commands: n }) => n.setMark(this.name), toggleCode: () => ({ commands: n }) => n.toggleMark(this.name), unsetCode: () => ({ commands: n }) => n.unsetMark(this.name) } }, addKeyboardShortcuts() { return { 'Mod-e': () => this.editor.commands.toggleCode() } }, addInputRules() { return [qe({ find: Hp, type: this.type })] }, addPasteRules() { return [Ne({ find: $p, type: this.type })] } }); const Kp = /^```([a-z]+)?[\s\n]$/; const jp = /^~~~([a-z]+)?[\s\n]$/; const Du = R.create({
  name: 'codeBlock',
  addOptions() { return { languageClassPrefix: 'language-', exitOnTripleEnter: !0, exitOnArrowDown: !0, HTMLAttributes: {} } },
  content: 'text*',
  marks: '',
  group: 'block',
  code: !0,
  defining: !0,
  addAttributes() { return { language: { default: null, parseHTML: (n) => { let e; const { languageClassPrefix: t } = this.options; const s = [...((e = n.firstElementChild) === null || e === void 0 ? void 0 : e.classList) || []].filter(o => o.startsWith(t)).map(o => o.replace(t, ''))[0]; return s || null }, rendered: !1 } } },
  parseHTML() { return [{ tag: 'pre', preserveWhitespace: 'full' }] },
  renderHTML({ node: n, HTMLAttributes: e }) { return ['pre', v(this.options.HTMLAttributes, e), ['code', { class: n.attrs.language ? this.options.languageClassPrefix + n.attrs.language : null }, 0]] },
  addCommands() { return { setCodeBlock: n => ({ commands: e }) => e.setNode(this.name, n), toggleCodeBlock: n => ({ commands: e }) => e.toggleNode(this.name, 'paragraph', n) } },
  addKeyboardShortcuts() {
    return {
      'Mod-Alt-c': () => this.editor.commands.toggleCodeBlock(),
      'Backspace': () => { const { empty: n, $anchor: e } = this.editor.state.selection; const t = e.pos === 1; return !n || e.parent.type.name !== this.name ? !1 : t || !e.parent.textContent.length ? this.editor.commands.clearNodes() : !1 },
      'Enter': ({ editor: n }) => {
        if (!this.options.exitOnTripleEnter)
          return !1; const { state: e } = n; const { selection: t } = e; const { $from: r, empty: i } = t; if (!i || r.parent.type !== this.type)
          return !1; const s = r.parentOffset === r.parent.nodeSize - 2; const o = r.parent.textContent.endsWith(`

`); return !s || !o ? !1 : n.chain().command(({ tr: l }) => (l.delete(r.pos - 2, r.pos), !0)).exitCode().run()
      },
      'ArrowDown': ({ editor: n }) => {
        if (!this.options.exitOnArrowDown)
          return !1; const { state: e } = n; const { selection: t, doc: r } = e; const { $from: i, empty: s } = t; if (!s || i.parent.type !== this.type || !(i.parentOffset === i.parent.nodeSize - 2))
          return !1; const l = i.after(); return l === void 0 || r.nodeAt(l) ? !1 : n.commands.exitCode()
      },
    }
  },
  addInputRules() { return [Yn({ find: Kp, type: this.type, getAttributes: n => ({ language: n[1] }) }), Yn({ find: jp, type: this.type, getAttributes: n => ({ language: n[1] }) })] },
  addProseMirrorPlugins() {
    return [new L({
      key: new _('codeBlockVSCodeHandler'),
      props: {
        handlePaste: (n, e) => {
          if (!e.clipboardData || this.editor.isActive(this.type.name))
            return !1; const t = e.clipboardData.getData('text/plain'); const r = e.clipboardData.getData('vscode-editor-data'); const i = r ? JSON.parse(r) : void 0; const s = i == null ? void 0 : i.mode; if (!t || !s)
            return !1; const { tr: o } = n.state; return o.replaceSelectionWith(this.type.create({ language: s })), o.setSelection(E.near(o.doc.resolve(Math.max(0, o.selection.from - 2)))), o.insertText(t.replace(/\r\n?/g, `
`)), o.setMeta('paste', !0), n.dispatch(o), !0
        },
      },
    })]
  },
}); const bu = R.create({ name: 'doc', topNode: !0, content: 'block+' }); const ku = 65535; const Su = 2 ** 16; function Wp(n, e) { return n + e * Su } function Cu(n) { return n & ku } function qp(n) { return (n - (n & ku)) / Su } const xu = 1; const Eu = 2; const jr = 4; const Au = 8; const Qn = class {constructor(e, t, r) { this.pos = e, this.delInfo = t, this.recover = r } get deleted() { return (this.delInfo & Au) > 0 } get deletedBefore() { return (this.delInfo & (xu | jr)) > 0 } get deletedAfter() { return (this.delInfo & (Eu | jr)) > 0 } get deletedAcross() { return (this.delInfo & jr) > 0 }}; var ge = class {
  constructor(e, t = !1) {
    if (this.ranges = e, this.inverted = t, !e.length && ge.empty)
      return ge.empty
  }

  recover(e) {
    let t = 0; const r = Cu(e); if (!this.inverted)
      for (let i = 0; i < r; i++)t += this.ranges[i * 3 + 2] - this.ranges[i * 3 + 1]; return this.ranges[r * 3] + t + qp(e)
  }

  mapResult(e, t = 1) { return this._map(e, t, !1) }map(e, t = 1) { return this._map(e, t, !0) }_map(e, t, r) {
    let i = 0; const s = this.inverted ? 2 : 1; const o = this.inverted ? 1 : 2; for (let l = 0; l < this.ranges.length; l += 3) {
      const a = this.ranges[l] - (this.inverted ? i : 0); if (a > e)
        break; const u = this.ranges[l + s]; const c = this.ranges[l + o]; const d = a + u; if (e <= d) {
        const f = u ? e == a ? -1 : e == d ? 1 : t : t; const h = a + i + (f < 0 ? 0 : c); if (r)
          return h; const p = e == (t < 0 ? a : d) ? null : Wp(l / 3, e - a); let m = e == a ? Eu : e == d ? xu : jr; return (t < 0 ? e != a : e != d) && (m |= Au), new Qn(h, m, p)
      }i += c - u
    } return r ? e + i : new Qn(e + i, 0, null)
  }

  touches(e, t) {
    let r = 0; const i = Cu(t); const s = this.inverted ? 2 : 1; const o = this.inverted ? 1 : 2; for (let l = 0; l < this.ranges.length; l += 3) {
      const a = this.ranges[l] - (this.inverted ? r : 0); if (a > e)
        break; const u = this.ranges[l + s]; const c = a + u; if (e <= c && l == i * 3)
        return !0; r += this.ranges[l + o] - u
    } return !1
  }

  forEach(e) { const t = this.inverted ? 2 : 1; const r = this.inverted ? 1 : 2; for (let i = 0, s = 0; i < this.ranges.length; i += 3) { const o = this.ranges[i]; const l = o - (this.inverted ? s : 0); const a = o + (this.inverted ? 0 : s); const u = this.ranges[i + t]; const c = this.ranges[i + r]; e(l, l + u, a, a + c), s += c - u } }invert() { return new ge(this.ranges, !this.inverted) }toString() { return (this.inverted ? '-' : '') + JSON.stringify(this.ranges) } static offset(e) { return e == 0 ? ge.empty : new ge(e < 0 ? [0, -e, 0] : [0, 0, e]) }
}; ge.empty = new ge([]); var St = class {
  constructor(e = [], t, r = 0, i = e.length) { this.maps = e, this.mirror = t, this.from = r, this.to = i }slice(e = 0, t = this.maps.length) { return new St(this.maps, this.mirror, e, t) }copy() { return new St(this.maps.slice(), this.mirror && this.mirror.slice(), this.from, this.to) }appendMap(e, t) { this.to = this.maps.push(e), t != null && this.setMirror(this.maps.length - 1, t) }appendMapping(e) { for (let t = 0, r = this.maps.length; t < e.maps.length; t++) { const i = e.getMirror(t); this.appendMap(e.maps[t], i != null && i < t ? r + i : void 0) } }getMirror(e) {
    if (this.mirror) {
      for (let t = 0; t < this.mirror.length; t++) {
        if (this.mirror[t] == e)
          return this.mirror[t + (t % 2 ? -1 : 1)]
      }
    }
  }

  setMirror(e, t) { this.mirror || (this.mirror = []), this.mirror.push(e, t) }appendMappingInverted(e) { for (let t = e.maps.length - 1, r = this.maps.length + e.maps.length; t >= 0; t--) { const i = e.getMirror(t); this.appendMap(e.maps[t].invert(), i != null && i > t ? r - i - 1 : void 0) } }invert() { const e = new St(); return e.appendMappingInverted(this), e }map(e, t = 1) {
    if (this.mirror)
      return this._map(e, t, !0); for (let r = this.from; r < this.to; r++)e = this.maps[r].map(e, t); return e
  }

  mapResult(e, t = 1) { return this._map(e, t, !1) }_map(e, t, r) { let i = 0; for (let s = this.from; s < this.to; s++) { const o = this.maps[s]; const l = o.mapResult(e, t); if (l.recover != null) { const a = this.getMirror(s); if (a != null && a > s && a < this.to) { s = a, e = this.maps[a].recover(l.recover); continue } }i |= l.delInfo, e = l.pos } return r ? e : new Qn(e, i, null) }
}; const Gs = Object.create(null); const se = class {
  getMap() { return ge.empty }merge(e) { return null } static fromJSON(e, t) {
    if (!t || !t.stepType)
      throw new RangeError('Invalid input for Step.fromJSON'); const r = Gs[t.stepType]; if (!r)
      throw new RangeError(`No step type ${t.stepType} defined`); return r.fromJSON(e, t)
  }

  static jsonID(e, t) {
    if (e in Gs)
      throw new RangeError(`Duplicate use of step JSON ID ${e}`); return Gs[e] = t, t.prototype.jsonID = e, t
  }
}; var K = class {
  constructor(e, t) { this.doc = e, this.failed = t } static ok(e) { return new K(e, null) } static fail(e) { return new K(null, e) } static fromReplace(e, t, r, i) {
    try { return K.ok(e.replace(t, r, i)) }
    catch (s) {
      if (s instanceof Re)
        return K.fail(s.message); throw s
    }
  }
}; function Qs(n, e, t) { const r = []; for (let i = 0; i < n.childCount; i++) { let s = n.child(i); s.content.size && (s = s.copy(Qs(s.content, e, s))), s.isInline && (s = e(s, t, i)), r.push(s) } return y.fromArray(r) } var rt = class extends se {
  constructor(e, t, r) { super(), this.from = e, this.to = t, this.mark = r }apply(e) { const t = e.slice(this.from, this.to); const r = e.resolve(this.from); const i = r.node(r.sharedDepth(this.to)); const s = new b(Qs(t.content, (o, l) => !o.isAtom || !l.type.allowsMarkType(this.mark.type) ? o : o.mark(this.mark.addToSet(o.marks)), i), t.openStart, t.openEnd); return K.fromReplace(e, this.from, this.to, s) }invert() { return new it(this.from, this.to, this.mark) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); return t.deleted && r.deleted || t.pos >= r.pos ? null : new rt(t.pos, r.pos, this.mark) }merge(e) { return e instanceof rt && e.mark.eq(this.mark) && this.from <= e.to && this.to >= e.from ? new rt(Math.min(this.from, e.from), Math.max(this.to, e.to), this.mark) : null }toJSON() { return { stepType: 'addMark', mark: this.mark.toJSON(), from: this.from, to: this.to } } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number')
      throw new RangeError('Invalid input for AddMarkStep.fromJSON'); return new rt(t.from, t.to, e.markFromJSON(t.mark))
  }
}; se.jsonID('addMark', rt); var it = class extends se {
  constructor(e, t, r) { super(), this.from = e, this.to = t, this.mark = r }apply(e) { const t = e.slice(this.from, this.to); const r = new b(Qs(t.content, i => i.mark(this.mark.removeFromSet(i.marks)), e), t.openStart, t.openEnd); return K.fromReplace(e, this.from, this.to, r) }invert() { return new rt(this.from, this.to, this.mark) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); return t.deleted && r.deleted || t.pos >= r.pos ? null : new it(t.pos, r.pos, this.mark) }merge(e) { return e instanceof it && e.mark.eq(this.mark) && this.from <= e.to && this.to >= e.from ? new it(Math.min(this.from, e.from), Math.max(this.to, e.to), this.mark) : null }toJSON() { return { stepType: 'removeMark', mark: this.mark.toJSON(), from: this.from, to: this.to } } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number')
      throw new RangeError('Invalid input for RemoveMarkStep.fromJSON'); return new it(t.from, t.to, e.markFromJSON(t.mark))
  }
}; se.jsonID('removeMark', it); var st = class extends se {
  constructor(e, t) { super(), this.pos = e, this.mark = t }apply(e) {
    const t = e.nodeAt(this.pos); if (!t)
      return K.fail('No node at mark step\'s position'); const r = t.type.create(t.attrs, null, this.mark.addToSet(t.marks)); return K.fromReplace(e, this.pos, this.pos + 1, new b(y.from(r), 0, t.isLeaf ? 0 : 1))
  }

  invert(e) {
    const t = e.nodeAt(this.pos); if (t) {
      const r = this.mark.addToSet(t.marks); if (r.length == t.marks.length) {
        for (let i = 0; i < t.marks.length; i++) {
          if (!t.marks[i].isInSet(r))
            return new st(this.pos, t.marks[i])
        } return new st(this.pos, this.mark)
      }
    } return new Jt(this.pos, this.mark)
  }

  map(e) { const t = e.mapResult(this.pos, 1); return t.deletedAfter ? null : new st(t.pos, this.mark) }toJSON() { return { stepType: 'addNodeMark', pos: this.pos, mark: this.mark.toJSON() } } static fromJSON(e, t) {
    if (typeof t.pos != 'number')
      throw new RangeError('Invalid input for AddNodeMarkStep.fromJSON'); return new st(t.pos, e.markFromJSON(t.mark))
  }
}; se.jsonID('addNodeMark', st); var Jt = class extends se {
  constructor(e, t) { super(), this.pos = e, this.mark = t }apply(e) {
    const t = e.nodeAt(this.pos); if (!t)
      return K.fail('No node at mark step\'s position'); const r = t.type.create(t.attrs, null, this.mark.removeFromSet(t.marks)); return K.fromReplace(e, this.pos, this.pos + 1, new b(y.from(r), 0, t.isLeaf ? 0 : 1))
  }

  invert(e) { const t = e.nodeAt(this.pos); return !t || !this.mark.isInSet(t.marks) ? this : new st(this.pos, this.mark) }map(e) { const t = e.mapResult(this.pos, 1); return t.deletedAfter ? null : new Jt(t.pos, this.mark) }toJSON() { return { stepType: 'removeNodeMark', pos: this.pos, mark: this.mark.toJSON() } } static fromJSON(e, t) {
    if (typeof t.pos != 'number')
      throw new RangeError('Invalid input for RemoveNodeMarkStep.fromJSON'); return new Jt(t.pos, e.markFromJSON(t.mark))
  }
}; se.jsonID('removeNodeMark', Jt); var _e = class extends se {
  constructor(e, t, r, i = !1) { super(), this.from = e, this.to = t, this.slice = r, this.structure = i }apply(e) { return this.structure && Ys(e, this.from, this.to) ? K.fail('Structure replace would overwrite content') : K.fromReplace(e, this.from, this.to, this.slice) }getMap() { return new ge([this.from, this.to - this.from, this.slice.size]) }invert(e) { return new _e(this.from, this.from + this.slice.size, e.slice(this.from, this.to)) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); return t.deletedAcross && r.deletedAcross ? null : new _e(t.pos, Math.max(t.pos, r.pos), this.slice) }merge(e) {
    if (!(e instanceof _e) || e.structure || this.structure)
      return null; if (this.from + this.slice.size == e.from && !this.slice.openEnd && !e.slice.openStart) { const t = this.slice.size + e.slice.size == 0 ? b.empty : new b(this.slice.content.append(e.slice.content), this.slice.openStart, e.slice.openEnd); return new _e(this.from, this.to + (e.to - e.from), t, this.structure) }
    else if (e.to == this.from && !this.slice.openStart && !e.slice.openEnd) { const t = this.slice.size + e.slice.size == 0 ? b.empty : new b(e.slice.content.append(this.slice.content), e.slice.openStart, this.slice.openEnd); return new _e(e.from, this.to, t, this.structure) }
    else { return null }
  }

  toJSON() { const e = { stepType: 'replace', from: this.from, to: this.to }; return this.slice.size && (e.slice = this.slice.toJSON()), this.structure && (e.structure = !0), e } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number')
      throw new RangeError('Invalid input for ReplaceStep.fromJSON'); return new _e(t.from, t.to, b.fromJSON(e, t.slice), !!t.structure)
  }
}; se.jsonID('replace', _e); var qt = class extends se {
  constructor(e, t, r, i, s, o, l = !1) { super(), this.from = e, this.to = t, this.gapFrom = r, this.gapTo = i, this.slice = s, this.insert = o, this.structure = l }apply(e) {
    if (this.structure && (Ys(e, this.from, this.gapFrom) || Ys(e, this.gapTo, this.to)))
      return K.fail('Structure gap-replace would overwrite content'); const t = e.slice(this.gapFrom, this.gapTo); if (t.openStart || t.openEnd)
      return K.fail('Gap is not a flat range'); const r = this.slice.insertAt(this.insert, t.content); return r ? K.fromReplace(e, this.from, this.to, r) : K.fail('Content does not fit in gap')
  }

  getMap() { return new ge([this.from, this.gapFrom - this.from, this.insert, this.gapTo, this.to - this.gapTo, this.slice.size - this.insert]) }invert(e) { const t = this.gapTo - this.gapFrom; return new qt(this.from, this.from + this.slice.size + t, this.from + this.insert, this.from + this.insert + t, e.slice(this.from, this.to).removeBetween(this.gapFrom - this.from, this.gapTo - this.from), this.gapFrom - this.from, this.structure) }map(e) { const t = e.mapResult(this.from, 1); const r = e.mapResult(this.to, -1); const i = e.map(this.gapFrom, -1); const s = e.map(this.gapTo, 1); return t.deletedAcross && r.deletedAcross || i < t.pos || s > r.pos ? null : new qt(t.pos, r.pos, i, s, this.slice, this.insert, this.structure) }toJSON() { const e = { stepType: 'replaceAround', from: this.from, to: this.to, gapFrom: this.gapFrom, gapTo: this.gapTo, insert: this.insert }; return this.slice.size && (e.slice = this.slice.toJSON()), this.structure && (e.structure = !0), e } static fromJSON(e, t) {
    if (typeof t.from != 'number' || typeof t.to != 'number' || typeof t.gapFrom != 'number' || typeof t.gapTo != 'number' || typeof t.insert != 'number')
      throw new RangeError('Invalid input for ReplaceAroundStep.fromJSON'); return new qt(t.from, t.to, t.gapFrom, t.gapTo, b.fromJSON(e, t.slice), t.insert, !!t.structure)
  }
}; se.jsonID('replaceAround', qt); function Ys(n, e, t) {
  const r = n.resolve(e); let i = t - e; let s = r.depth; for (;i > 0 && s > 0 && r.indexAfter(s) == r.node(s).childCount;)s--, i--; if (i > 0) {
    let o = r.node(s).maybeChild(r.indexAfter(s)); for (;i > 0;) {
      if (!o || o.isLeaf)
        return !0; o = o.firstChild, i--
    }
  } return !1
} function Wr(n, e, t) {
  const r = n.resolve(e); if (!t.content.size)
    return e; let i = t.content; for (let s = 0; s < t.openStart; s++)i = i.firstChild.content; for (let s = 1; s <= (t.openStart == 0 && t.size ? 2 : 1); s++) {
    for (let o = r.depth; o >= 0; o--) {
      const l = o == r.depth ? 0 : r.pos <= (r.start(o + 1) + r.end(o + 1)) / 2 ? -1 : 1; const a = r.index(o) + (l > 0 ? 1 : 0); const u = r.node(o); let c = !1; if (s == 1) { c = u.canReplace(a, a, i) }
      else { const d = u.contentMatchAt(a).findWrapping(i.firstChild.type); c = d && u.canReplaceWith(a, a, d[0]) } if (c)
        return l == 0 ? r.pos : l < 0 ? r.before(o + 1) : r.after(o + 1)
    }
  } return null
} var _t = class extends se {
  constructor(e, t, r) { super(), this.pos = e, this.attr = t, this.value = r }apply(e) {
    const t = e.nodeAt(this.pos); if (!t)
      return K.fail('No node at attribute step\'s position'); const r = Object.create(null); for (const s in t.attrs)r[s] = t.attrs[s]; r[this.attr] = this.value; const i = t.type.create(r, null, t.marks); return K.fromReplace(e, this.pos, this.pos + 1, new b(y.from(i), 0, t.isLeaf ? 0 : 1))
  }

  getMap() { return ge.empty }invert(e) { return new _t(this.pos, this.attr, e.nodeAt(this.pos).attrs[this.attr]) }map(e) { const t = e.mapResult(this.pos, 1); return t.deletedAfter ? null : new _t(t.pos, this.attr, this.value) }toJSON() { return { stepType: 'attr', pos: this.pos, attr: this.attr, value: this.value } } static fromJSON(e, t) {
    if (typeof t.pos != 'number' || typeof t.attr != 'string')
      throw new RangeError('Invalid input for AttrStep.fromJSON'); return new _t(t.pos, t.attr, t.value)
  }
}; se.jsonID('attr', _t); let Xn = class extends Error {}; Xn = function n(e) { const t = Error.call(this, e); return t.__proto__ = n.prototype, t }; Xn.prototype = Object.create(Error.prototype); Xn.prototype.constructor = Xn; Xn.prototype.name = 'TransformError'; function Mu(n = {}) { return new L({ view(e) { return new Xs(e, n) } }) } var Xs = class {
  constructor(e, t) { this.editorView = e, this.cursorPos = null, this.element = null, this.timeout = -1, this.width = t.width || 1, this.color = t.color || 'black', this.class = t.class, this.handlers = ['dragover', 'dragend', 'drop', 'dragleave'].map((r) => { const i = (s) => { this[r](s) }; return e.dom.addEventListener(r, i), { name: r, handler: i } }) }destroy() { this.handlers.forEach(({ name: e, handler: t }) => this.editorView.dom.removeEventListener(e, t)) }update(e, t) { this.cursorPos != null && t.doc != e.state.doc && (this.cursorPos > e.state.doc.content.size ? this.setCursor(null) : this.updateOverlay()) }setCursor(e) { e != this.cursorPos && (this.cursorPos = e, e == null ? (this.element.parentNode.removeChild(this.element), this.element = null) : this.updateOverlay()) }updateOverlay() {
    const e = this.editorView.state.doc.resolve(this.cursorPos); let t; if (!e.parent.inlineContent) { const o = e.nodeBefore; const l = e.nodeAfter; if (o || l) { const a = this.editorView.nodeDOM(this.cursorPos - (o ? o.nodeSize : 0)).getBoundingClientRect(); let u = o ? a.bottom : a.top; o && l && (u = (u + this.editorView.nodeDOM(this.cursorPos).getBoundingClientRect().top) / 2), t = { left: a.left, right: a.right, top: u - this.width / 2, bottom: u + this.width / 2 } } } if (!t) { const o = this.editorView.coordsAtPos(this.cursorPos); t = { left: o.left - this.width / 2, right: o.left + this.width / 2, top: o.top, bottom: o.bottom } } const r = this.editorView.dom.offsetParent; this.element || (this.element = r.appendChild(document.createElement('div')), this.class && (this.element.className = this.class), this.element.style.cssText = `position: absolute; z-index: 50; pointer-events: none; background-color: ${this.color}`); let i, s; if (!r || r == document.body && getComputedStyle(r).position == 'static') { i = -pageXOffset, s = -pageYOffset }
    else { const o = r.getBoundingClientRect(); i = o.left - r.scrollLeft, s = o.top - r.scrollTop } this.element.style.left = `${t.left - i}px`, this.element.style.top = `${t.top - s}px`, this.element.style.width = `${t.right - t.left}px`, this.element.style.height = `${t.bottom - t.top}px`
  }

  scheduleRemoval(e) { clearTimeout(this.timeout), this.timeout = setTimeout(() => this.setCursor(null), e) }dragover(e) {
    if (!this.editorView.editable)
      return; const t = this.editorView.posAtCoords({ left: e.clientX, top: e.clientY }); const r = t && t.inside >= 0 && this.editorView.state.doc.nodeAt(t.inside); const i = r && r.type.spec.disableDropCursor; const s = typeof i == 'function' ? i(this.editorView, t) : i; if (t && !s) {
      let o = t.pos; if (this.editorView.dragging && this.editorView.dragging.slice && (o = Wr(this.editorView.state.doc, o, this.editorView.dragging.slice), o == null))
        return this.setCursor(null); this.setCursor(o), this.scheduleRemoval(5e3)
    }
  }

  dragend() { this.scheduleRemoval(20) }drop() { this.scheduleRemoval(20) }dragleave(e) { (e.target == this.editorView.dom || !this.editorView.dom.contains(e.relatedTarget)) && this.setCursor(null) }
}; const Ou = H.create({ name: 'dropCursor', addOptions() { return { color: 'currentColor', width: 1, class: void 0 } }, addProseMirrorPlugins() { return [Mu(this.options)] } }); const Et = typeof navigator < 'u' ? navigator : null; const Tu = typeof document < 'u' ? document : null; const At = Et && Et.userAgent || ''; const no = /Edge\/(\d+)/.exec(At); const $u = /MSIE \d/.exec(At); const ro = /Trident\/(?:[7-9]|\d{2,})\..*rv:(\d+)/.exec(At); const An = !!($u || ro || no); const fo = $u ? document.documentMode : ro ? +ro[1] : no ? +no[1] : 0; const Gr = !An && /gecko\/(\d+)/i.test(At); Gr && +(/Firefox\/(\d+)/.exec(At) || [0, 0])[1]; const io = !An && /Chrome\/(\d+)/.exec(At); const Qt = !!io; const _p = io ? +io[1] : 0; const Xt = !An && !!Et && /Apple Computer/.test(Et.vendor); const ho = Xt && (/Mobile\/\w+/.test(At) || !!Et && Et.maxTouchPoints > 2); const we = ho || (Et ? /Mac/.test(Et.platform) : !1); const rr = /Android \d/.test(At); const po = !!Tu && 'webkitFontSmoothing' in Tu.documentElement.style; const Jp = po ? +(/\bAppleWebKit\/(\d+)/.exec(navigator.userAgent) || [0, 0])[1] : 0; const ir = function (n) {
  for (let e = 0; ;e++) {
    if (n = n.previousSibling, !n)
      return e
  }
}; const Up = function (n, e, t, r) { return t && (Nu(n, e, t, r, -1) || Nu(n, e, t, r, 1)) }; const Gp = /^(img|br|input|textarea|hr)$/i; function Nu(n, e, t, r, i) {
  for (;;) {
    if (n == t && e == r)
      return !0; if (e == (i < 0 ? 0 : qr(n))) {
      const s = n.parentNode; if (!s || s.nodeType != 1 || Qp(n) || Gp.test(n.nodeName) || n.contentEditable == 'false')
        return !1; e = ir(n) + (i < 0 ? 0 : 1), n = s
    }
    else if (n.nodeType == 1) {
      if (n = n.childNodes[e + (i < 0 ? -1 : 0)], n.contentEditable == 'false')
        return !1; e = i < 0 ? qr(n) : 0
    }
    else { return !1 }
  }
} function qr(n) { return n.nodeType == 3 ? n.nodeValue.length : n.childNodes.length } function Yp(n, e, t) {
  for (let r = e == 0, i = e == qr(n); r || i;) {
    if (n == t)
      return !0; const s = ir(n); if (n = n.parentNode, !n)
      return !1; r = r && s == 0, i = i && s == qr(n)
  }
} function Qp(n) { let e; for (let t = n; t && !(e = t.pmViewDesc); t = t.parentNode);return e && e.node && e.node.isBlock && (e.dom == n || e.contentDOM == n) } const Ku = function (n) { let e = n.isCollapsed; return e && Qt && n.rangeCount && !n.getRangeAt(0).collapsed && (e = !1), e }; function ju(n, e) { const t = document.createEvent('Event'); return t.initEvent('keydown', !0, !0), t.keyCode = n, t.key = t.code = e, t } const Wu = function (n) { n && (this.nodeName = n) }; Wu.prototype = Object.create(null); const L0 = [new Wu()]; function Xp(n, e = null) {
  const t = n.domSelection(); const r = n.state.doc; if (!t.focusNode)
    return null; let i = n.docView.nearestDesc(t.focusNode); const s = i && i.size == 0; const o = n.docView.posFromDOM(t.focusNode, t.focusOffset, 1); if (o < 0)
    return null; const l = r.resolve(o); let a; let u; if (Ku(t)) { for (a = l; i && !i.node;)i = i.parent; const c = i.node; if (i && c.isAtom && k.isSelectable(c) && i.parent && !(c.isInline && Yp(t.focusNode, t.focusOffset, i.dom))) { const d = i.posBefore; u = new k(o == d ? l : r.resolve(d)) } }
  else {
    const c = n.docView.posFromDOM(t.anchorNode, t.anchorOffset, 1); if (c < 0)
      return null; a = r.resolve(c)
  } if (!u) { const c = e == 'pointer' || n.state.selection.head < l.pos && !s ? 1 : -1; u = _u(n, a, l, c) } return u
} function qu(n) { return n.editable ? n.hasFocus() : nm(n) && document.activeElement && document.activeElement.contains(n.dom) } function mo(n, e = !1) {
  const t = n.state.selection; if (tm(n, t), !!qu(n)) {
    if (!e && n.input.mouseDown && n.input.mouseDown.allowDefault && Qt) { const r = n.domSelection(); const i = n.domObserver.currentSelection; if (r.anchorNode && i.anchorNode && Up(r.anchorNode, r.anchorOffset, i.anchorNode, i.anchorOffset)) { n.input.mouseDown.delayedSelectionSync = !0, n.domObserver.setCurSelection(); return } } if (n.domObserver.disconnectSelection(), n.cursorWrapper) { em(n) }
    else { const { anchor: r, head: i } = t; let s; let o; wu && !(t instanceof E) && (t.$from.parent.inlineContent || (s = Fu(n, t.from)), !t.empty && !t.$from.parent.inlineContent && (o = Fu(n, t.to))), n.docView.setSelection(r, i, n.root, e), wu && (s && vu(s), o && vu(o)), t.visible ? n.dom.classList.remove('ProseMirror-hideselection') : (n.dom.classList.add('ProseMirror-hideselection'), 'onselectionchange' in document && Zp(n)) }n.domObserver.setCurSelection(), n.domObserver.connectSelection()
  }
} var wu = Xt || Qt && _p < 63; function Fu(n, e) {
  const { node: t, offset: r } = n.docView.domFromPos(e, 0); const i = r < t.childNodes.length ? t.childNodes[r] : null; const s = r ? t.childNodes[r - 1] : null; if (Xt && i && i.contentEditable == 'false')
    return Zs(i); if ((!i || i.contentEditable == 'false') && (!s || s.contentEditable == 'false')) {
    if (i)
      return Zs(i); if (s)
      return Zs(s)
  }
} function Zs(n) { return n.contentEditable = 'true', Xt && n.draggable && (n.draggable = !1, n.wasDraggable = !0), n } function vu(n) { n.contentEditable = 'false', n.wasDraggable && (n.draggable = !0, n.wasDraggable = null) } function Zp(n) { const e = n.dom.ownerDocument; e.removeEventListener('selectionchange', n.input.hideSelectionGuard); const t = n.domSelection(); const r = t.anchorNode; const i = t.anchorOffset; e.addEventListener('selectionchange', n.input.hideSelectionGuard = () => { (t.anchorNode != r || t.anchorOffset != i) && (e.removeEventListener('selectionchange', n.input.hideSelectionGuard), setTimeout(() => { (!qu(n) || n.state.selection.visible) && n.dom.classList.remove('ProseMirror-hideselection') }, 20)) }) } function em(n) { const e = n.domSelection(); const t = document.createRange(); const r = n.cursorWrapper.dom; const i = r.nodeName == 'IMG'; i ? t.setEnd(r.parentNode, ir(r) + 1) : t.setEnd(r, 0), t.collapse(!1), e.removeAllRanges(), e.addRange(t), !i && !n.state.selection.visible && An && fo <= 11 && (r.disabled = !0, r.disabled = !1) } function tm(n, e) {
  if (e instanceof k) { const t = n.docView.descAt(e.from); t != n.lastSelectedViewDesc && (Bu(n), t && t.selectNode(), n.lastSelectedViewDesc = t) }
  else { Bu(n) }
} function Bu(n) { n.lastSelectedViewDesc && (n.lastSelectedViewDesc.parent && n.lastSelectedViewDesc.deselectNode(), n.lastSelectedViewDesc = void 0) } function _u(n, e, t, r) { return n.someProp('createSelectionBetween', i => i(n, e, t)) || E.between(e, t, r) } function nm(n) {
  const e = n.domSelection(); if (!e.anchorNode)
    return !1; try { return n.dom.contains(e.anchorNode.nodeType == 3 ? e.anchorNode.parentNode : e.anchorNode) && (n.editable || n.dom.contains(e.focusNode.nodeType == 3 ? e.focusNode.parentNode : e.focusNode)) }
  catch { return !1 }
} function so(n, e) { const { $anchor: t, $head: r } = n.selection; const i = e > 0 ? t.max(r) : t.min(r); const s = i.parent.inlineContent ? i.depth ? n.doc.resolve(e > 0 ? i.after() : i.before()) : null : i; return s && M.findFrom(s, e) } function Ut(n, e) { return n.dispatch(n.state.tr.setSelection(e).scrollIntoView()), !0 } function Iu(n, e, t) {
  const r = n.state.selection; if (r instanceof E) {
    if (!r.empty || t.includes('s'))
      return !1; if (n.endOfTextblock(e > 0 ? 'right' : 'left')) { const i = so(n.state, e); return i && i instanceof k ? Ut(n, i) : !1 }
    else if (!(we && t.includes('m'))) {
      const i = r.$head; const s = i.textOffset ? null : e < 0 ? i.nodeBefore : i.nodeAfter; let o; if (!s || s.isText)
        return !1; const l = e < 0 ? i.pos - s.nodeSize : i.pos; return s.isAtom || (o = n.docView.descAt(l)) && !o.contentDOM ? k.isSelectable(s) ? Ut(n, new k(e < 0 ? n.state.doc.resolve(i.pos - s.nodeSize) : i)) : po ? Ut(n, new E(n.state.doc.resolve(e < 0 ? l : l + s.nodeSize))) : !1 : !1
    }
  }
  else {
    if (r instanceof k && r.node.isInline)
      return Ut(n, new E(e > 0 ? r.$to : r.$from)); { const i = so(n.state, e); return i ? Ut(n, i) : !1 }
  }
} function _r(n) { return n.nodeType == 3 ? n.nodeValue.length : n.childNodes.length } function Zn(n) { const e = n.pmViewDesc; return e && e.size == 0 && (n.nextSibling || n.nodeName != 'BR') } function eo(n) {
  const e = n.domSelection(); let t = e.focusNode; let r = e.focusOffset; if (!t)
    return; let i; let s; let o = !1; for (Gr && t.nodeType == 1 && r < _r(t) && Zn(t.childNodes[r]) && (o = !0); ;) {
    if (r > 0) {
      if (t.nodeType != 1)
        break; { const l = t.childNodes[r - 1]; if (Zn(l))
        i = t, s = --r; else if (l.nodeType == 3)
        t = l, r = t.nodeValue.length; else break }
    }
    else {
      if (Ju(t))
        break; { let l = t.previousSibling; for (;l && Zn(l);)i = t.parentNode, s = ir(l), l = l.previousSibling; if (l) { t = l, r = _r(t) }
      else {
        if (t = t.parentNode, t == n.dom)
          break; r = 0
      } }
    }
  }o ? oo(n, e, t, r) : i && oo(n, e, i, s)
} function to(n) {
  const e = n.domSelection(); let t = e.focusNode; let r = e.focusOffset; if (!t)
    return; let i = _r(t); let s; let o; for (;;) {
    if (r < i) {
      if (t.nodeType != 1)
        break; const l = t.childNodes[r]; if (Zn(l))
        s = t, o = ++r; else break
    }
    else {
      if (Ju(t))
        break; { let l = t.nextSibling; for (;l && Zn(l);)s = l.parentNode, o = ir(l) + 1, l = l.nextSibling; if (l) { t = l, r = 0, i = _r(t) }
      else {
        if (t = t.parentNode, t == n.dom)
          break; r = i = 0
      } }
    }
  }s && oo(n, e, s, o)
} function Ju(n) { const e = n.pmViewDesc; return e && e.node && e.node.isBlock } function oo(n, e, t, r) {
  if (Ku(e)) { const s = document.createRange(); s.setEnd(t, r), s.setStart(t, r), e.removeAllRanges(), e.addRange(s) }
  else { e.extend && e.extend(t, r) }n.domObserver.setCurSelection(); const { state: i } = n; setTimeout(() => { n.state == i && mo(n) }, 50)
} function Pu(n, e, t) {
  const r = n.state.selection; if (r instanceof E && !r.empty || t.includes('s') || we && t.includes('m'))
    return !1; const { $from: i, $to: s } = r; if (!i.parent.inlineContent || n.endOfTextblock(e < 0 ? 'up' : 'down')) {
    const o = so(n.state, e); if (o && o instanceof k)
      return Ut(n, o)
  } if (!i.parent.inlineContent) { const o = e < 0 ? i : s; const l = r instanceof q ? M.near(o, e) : M.findFrom(o, e); return l ? Ut(n, l) : !1 } return !1
} function Ru(n, e) {
  if (!(n.state.selection instanceof E))
    return !0; const { $head: t, $anchor: r, empty: i } = n.state.selection; if (!t.sameParent(r))
    return !0; if (!i)
    return !1; if (n.endOfTextblock(e > 0 ? 'forward' : 'backward'))
    return !0; const s = !t.textOffset && (e < 0 ? t.nodeBefore : t.nodeAfter); if (s && !s.isText) { const o = n.state.tr; return e < 0 ? o.delete(t.pos - s.nodeSize, t.pos) : o.delete(t.pos, t.pos + s.nodeSize), n.dispatch(o), !0 } return !1
} function Lu(n, e, t) { n.domObserver.stop(), e.contentEditable = t, n.domObserver.start() } function rm(n) {
  if (!Xt || n.state.selection.$head.parentOffset > 0)
    return !1; const { focusNode: e, focusOffset: t } = n.domSelection(); if (e && e.nodeType == 1 && t == 0 && e.firstChild && e.firstChild.contentEditable == 'false') { const r = e.firstChild; Lu(n, r, 'true'), setTimeout(() => Lu(n, r, 'false'), 20) } return !1
} function im(n) { let e = ''; return n.ctrlKey && (e += 'c'), n.metaKey && (e += 'm'), n.altKey && (e += 'a'), n.shiftKey && (e += 's'), e } function sm(n, e) { const t = e.keyCode; const r = im(e); return t == 8 || we && t == 72 && r == 'c' ? Ru(n, -1) || eo(n) : t == 46 || we && t == 68 && r == 'c' ? Ru(n, 1) || to(n) : t == 13 || t == 27 ? !0 : t == 37 || we && t == 66 && r == 'c' ? Iu(n, -1, r) || eo(n) : t == 39 || we && t == 70 && r == 'c' ? Iu(n, 1, r) || to(n) : t == 38 || we && t == 80 && r == 'c' ? Pu(n, -1, r) || eo(n) : t == 40 || we && t == 78 && r == 'c' ? rm(n) || Pu(n, 1, r) || to(n) : r == (we ? 'm' : 'c') && (t == 66 || t == 73 || t == 89 || t == 90) } function Uu(n, e) {
  n.someProp('transformCopied', (h) => { e = h(e) }); const t = []; let { content: r, openStart: i, openEnd: s } = e; for (;i > 1 && s > 1 && r.childCount == 1 && r.firstChild.childCount == 1;) { i--, s--; const h = r.firstChild; t.push(h.type.name, h.attrs != h.type.defaultAttrs ? h.attrs : null), r = h.content } const o = n.someProp('clipboardSerializer') || X.fromSchema(n.state.schema); const l = ec(); const a = l.createElement('div'); a.appendChild(o.serializeFragment(r, { document: l })); let u = a.firstChild; let c; let d = 0; for (;u && u.nodeType == 1 && (c = Zu[u.nodeName.toLowerCase()]);) { for (let h = c.length - 1; h >= 0; h--) { const p = l.createElement(c[h]); for (;a.firstChild;)p.appendChild(a.firstChild); a.appendChild(p), d++ }u = a.firstChild }u && u.nodeType == 1 && u.setAttribute('data-pm-slice', `${i} ${s}${d ? ` -${d}` : ''} ${JSON.stringify(t)}`); const f = n.someProp('clipboardTextSerializer', h => h(e)) || e.content.textBetween(0, e.content.size, `

`); return { dom: a, text: f }
} function Gu(n, e, t, r, i) {
  const s = i.parent.type.spec.code; let o; let l; if (!t && !e)
    return null; const a = e && (r || s || !t); if (a) {
    if (n.someProp('transformPastedText', (f) => { e = f(e, s || r) }), s) {
      return e
        ? new b(y.from(n.state.schema.text(e.replace(/\r\n?/g, `
`))), 0, 0)
        : b.empty
    } const d = n.someProp('clipboardTextParser', f => f(e, i, r)); if (d) { l = d }
    else { const f = i.marks(); const { schema: h } = n.state; const p = X.fromSchema(h); o = document.createElement('div'), e.split(/(?:\r\n?|\n)+/).forEach((m) => { const g = o.appendChild(document.createElement('p')); m && g.appendChild(p.serializeNode(h.text(m, f))) }) }
  }
  else { n.someProp('transformPastedHTML', (d) => { t = d(t) }), o = am(t), po && um(o) } const u = o && o.querySelector('[data-pm-slice]'); const c = u && /^(\d+) (\d+)(?: -(\d+))? (.*)/.exec(u.getAttribute('data-pm-slice') || ''); if (c && c[3])
    for (let d = +c[3]; d > 0 && o.firstChild; d--)o = o.firstChild; if (l || (l = (n.someProp('clipboardParser') || n.someProp('domParser') || Ae.fromSchema(n.state.schema)).parseSlice(o, { preserveWhitespace: !!(a || c), context: i, ruleFromNode(f) { return f.nodeName == 'BR' && !f.nextSibling && f.parentNode && !om.test(f.parentNode.nodeName) ? { ignore: !0 } : null } })), c) { l = cm(zu(l, +c[1], +c[2]), c[4]) }
  else if (l = b.maxOpen(lm(l.content, i), !0), l.openStart || l.openEnd) { let d = 0; let f = 0; for (let h = l.content.firstChild; d < l.openStart && !h.type.spec.isolating; d++, h = h.firstChild);for (let h = l.content.lastChild; f < l.openEnd && !h.type.spec.isolating; f++, h = h.lastChild);l = zu(l, d, f) } return n.someProp('transformPasted', (d) => { l = d(l) }), l
} var om = /^(a|abbr|acronym|b|cite|code|del|em|i|ins|kbd|label|output|q|ruby|s|samp|span|strong|sub|sup|time|u|tt|var)$/i; function lm(n, e) {
  if (n.childCount < 2)
    return n; for (let t = e.depth; t >= 0; t--) {
    let i = e.node(t).contentMatchAt(e.index(t)); let s; let o = []; if (n.forEach((l) => {
      if (!o)
        return; const a = i.findWrapping(l.type); let u; if (!a)
        return o = null; if (u = o.length && s.length && Qu(a, s, l, o[o.length - 1], 0)) { o[o.length - 1] = u }
      else { o.length && (o[o.length - 1] = Xu(o[o.length - 1], s.length)); const c = Yu(l, a); o.push(c), i = i.matchType(c.type), s = a }
    }), o)
      return y.from(o)
  } return n
} function Yu(n, e, t = 0) { for (let r = e.length - 1; r >= t; r--)n = e[r].create(null, y.from(n)); return n } function Qu(n, e, t, r, i) {
  if (i < n.length && i < e.length && n[i] == e[i]) {
    const s = Qu(n, e, t, r.lastChild, i + 1); if (s)
      return r.copy(r.content.replaceChild(r.childCount - 1, s)); if (r.contentMatchAt(r.childCount).matchType(i == n.length - 1 ? t.type : n[i + 1]))
      return r.copy(r.content.append(y.from(Yu(t, n, i + 1))))
  }
} function Xu(n, e) {
  if (e == 0)
    return n; const t = n.content.replaceChild(n.childCount - 1, Xu(n.lastChild, e - 1)); const r = n.contentMatchAt(n.childCount).fillBefore(y.empty, !0); return n.copy(t.append(r))
} function lo(n, e, t, r, i, s) { const o = e < 0 ? n.firstChild : n.lastChild; let l = o.content; return i < r - 1 && (l = lo(l, e, t, r, i + 1, s)), i >= t && (l = e < 0 ? o.contentMatchAt(0).fillBefore(l, n.childCount > 1 || s <= i).append(l) : l.append(o.contentMatchAt(o.childCount).fillBefore(y.empty, !0))), n.replaceChild(e < 0 ? 0 : n.childCount - 1, o.copy(l)) } function zu(n, e, t) { return e < n.openStart && (n = new b(lo(n.content, -1, e, n.openStart, 0, n.openEnd), e, n.openEnd)), t < n.openEnd && (n = new b(lo(n.content, 1, t, n.openEnd, 0, 0), n.openStart, t)), n } var Zu = { thead: ['table'], tbody: ['table'], tfoot: ['table'], caption: ['table'], colgroup: ['table'], col: ['table', 'colgroup'], tr: ['table', 'tbody'], td: ['table', 'tbody', 'tr'], th: ['table', 'tbody', 'tr'] }; let Vu = null; function ec() { return Vu || (Vu = document.implementation.createHTMLDocument('title')) } function am(n) {
  const e = /^(\s*<meta [^>]*>)*/.exec(n); e && (n = n.slice(e[0].length)); let t = ec().createElement('div'); const r = /<([a-z][^>\s]+)/i.exec(n); let i; if ((i = r && Zu[r[1].toLowerCase()]) && (n = i.map(s => `<${s}>`).join('') + n + i.map(s => `</${s}>`).reverse().join('')), t.innerHTML = n, i)
    for (let s = 0; s < i.length; s++)t = t.querySelector(i[s]) || t; return t
} function um(n) { const e = n.querySelectorAll(Qt ? 'span:not([class]):not([style])' : 'span.Apple-converted-space'); for (let t = 0; t < e.length; t++) { const r = e[t]; r.childNodes.length == 1 && r.textContent == '\xA0' && r.parentNode && r.parentNode.replaceChild(n.ownerDocument.createTextNode(' '), r) } } function cm(n, e) {
  if (!n.size)
    return n; const t = n.content.firstChild.type.schema; let r; try { r = JSON.parse(e) }
  catch { return n } let { content: i, openStart: s, openEnd: o } = n; for (let l = r.length - 2; l >= 0; l -= 2) {
    const a = t.nodes[r[l]]; if (!a || a.hasRequiredAttrs())
      break; i = y.from(a.create(r[l + 1], i)), s++, o++
  } return new b(i, s, o)
} const Ie = {}; const Se = {}; function xt(n, e) { n.input.lastSelectionOrigin = e, n.input.lastSelectionTime = Date.now() }Se.keydown = (n, e) => {
  const t = e; if (n.input.shiftKey = t.keyCode == 16 || t.shiftKey, !nc(n, t) && (n.input.lastKeyCode = t.keyCode, n.input.lastKeyCodeTime = Date.now(), !(rr && Qt && t.keyCode == 13))) {
    if (t.keyCode != 229 && n.domObserver.forceFlush(), ho && t.keyCode == 13 && !t.ctrlKey && !t.altKey && !t.metaKey) { const r = Date.now(); n.input.lastIOSEnter = r, n.input.lastIOSEnterFallbackTimeout = setTimeout(() => { n.input.lastIOSEnter == r && (n.someProp('handleKeyDown', i => i(n, ju(13, 'Enter'))), n.input.lastIOSEnter = 0) }, 200) }
    else { n.someProp('handleKeyDown', r => r(n, t)) || sm(n, t) ? t.preventDefault() : xt(n, 'key') }
  }
}; Se.keyup = (n, e) => { e.keyCode == 16 && (n.input.shiftKey = !1) }; Se.keypress = (n, e) => {
  const t = e; if (nc(n, t) || !t.charCode || t.ctrlKey && !t.altKey || we && t.metaKey)
    return; if (n.someProp('handleKeyPress', i => i(n, t))) { t.preventDefault(); return } const r = n.state.selection; if (!(r instanceof E) || !r.$from.sameParent(r.$to)) { const i = String.fromCharCode(t.charCode); n.someProp('handleTextInput', s => s(n, r.$from.pos, r.$to.pos, i)) || n.dispatch(n.state.tr.insertText(i).scrollIntoView()), t.preventDefault() }
}; function Yr(n) { return { left: n.clientX, top: n.clientY } } function dm(n, e) { const t = e.x - n.clientX; const r = e.y - n.clientY; return t * t + r * r < 100 } function go(n, e, t, r, i) {
  if (r == -1)
    return !1; const s = n.state.doc.resolve(r); for (let o = s.depth + 1; o > 0; o--) {
    if (n.someProp(e, l => o > s.depth ? l(n, t, s.nodeAfter, s.before(o), i, !0) : l(n, t, s.node(o), s.before(o), i, !1)))
      return !0
  } return !1
} function xn(n, e, t) { n.focused || n.focus(); const r = n.state.tr.setSelection(e); t == 'pointer' && r.setMeta('pointer', !0), n.dispatch(r) } function fm(n, e) {
  if (e == -1)
    return !1; const t = n.state.doc.resolve(e); const r = t.nodeAfter; return r && r.isAtom && k.isSelectable(r) ? (xn(n, new k(t), 'pointer'), !0) : !1
} function hm(n, e) {
  if (e == -1)
    return !1; const t = n.state.selection; let r; let i; t instanceof k && (r = t.node); const s = n.state.doc.resolve(e); for (let o = s.depth + 1; o > 0; o--) { const l = o > s.depth ? s.nodeAfter : s.node(o); if (k.isSelectable(l)) { r && t.$from.depth > 0 && o >= t.$from.depth && s.before(t.$from.depth + 1) == t.$from.pos ? i = s.before(t.$from.depth) : i = s.before(o); break } } return i != null ? (xn(n, k.create(n.state.doc, i), 'pointer'), !0) : !1
} function pm(n, e, t, r, i) { return go(n, 'handleClickOn', e, t, r) || n.someProp('handleClick', s => s(n, e, r)) || (i ? hm(n, t) : fm(n, t)) } function mm(n, e, t, r) { return go(n, 'handleDoubleClickOn', e, t, r) || n.someProp('handleDoubleClick', i => i(n, e, r)) } function gm(n, e, t, r) { return go(n, 'handleTripleClickOn', e, t, r) || n.someProp('handleTripleClick', i => i(n, e, r)) || ym(n, t, r) } function ym(n, e, t) {
  if (t.button != 0)
    return !1; const r = n.state.doc; if (e == -1)
    return r.inlineContent ? (xn(n, E.create(r, 0, r.content.size), 'pointer'), !0) : !1; const i = r.resolve(e); for (let s = i.depth + 1; s > 0; s--) {
    const o = s > i.depth ? i.nodeAfter : i.node(s); const l = i.before(s); if (o.inlineContent)
      xn(n, E.create(r, l + 1, l + 1 + o.content.size), 'pointer'); else if (k.isSelectable(o))
      xn(n, k.create(r, l), 'pointer'); else continue; return !0
  }
} function yo(n) { return Jr(n) } const tc = we ? 'metaKey' : 'ctrlKey'; Ie.mousedown = (n, e) => { const t = e; n.input.shiftKey = t.shiftKey; const r = yo(n); const i = Date.now(); let s = 'singleClick'; i - n.input.lastClick.time < 500 && dm(t, n.input.lastClick) && !t[tc] && (n.input.lastClick.type == 'singleClick' ? s = 'doubleClick' : n.input.lastClick.type == 'doubleClick' && (s = 'tripleClick')), n.input.lastClick = { time: i, x: t.clientX, y: t.clientY, type: s }; const o = n.posAtCoords(Yr(t)); !o || (s == 'singleClick' ? (n.input.mouseDown && n.input.mouseDown.done(), n.input.mouseDown = new ao(n, o, t, !!r)) : (s == 'doubleClick' ? mm : gm)(n, o.pos, o.inside, t) ? t.preventDefault() : xt(n, 'pointer')) }; var ao = class {
  constructor(e, t, r, i) {
    this.view = e, this.pos = t, this.event = r, this.flushed = i, this.delayedSelectionSync = !1, this.mightDrag = null, this.startDoc = e.state.doc, this.selectNode = !!r[tc], this.allowDefault = r.shiftKey; let s, o; if (t.inside > -1) { s = e.state.doc.nodeAt(t.inside), o = t.inside }
    else { const c = e.state.doc.resolve(t.pos); s = c.parent, o = c.depth ? c.before() : 0 } const l = i ? null : r.target; const a = l ? e.docView.nearestDesc(l, !0) : null; this.target = a ? a.dom : null; const { selection: u } = e.state; (r.button == 0 && s.type.spec.draggable && s.type.spec.selectable !== !1 || u instanceof k && u.from <= o && u.to > o) && (this.mightDrag = { node: s, pos: o, addAttr: !!(this.target && !this.target.draggable), setUneditable: !!(this.target && Gr && !this.target.hasAttribute('contentEditable')) }), this.target && this.mightDrag && (this.mightDrag.addAttr || this.mightDrag.setUneditable) && (this.view.domObserver.stop(), this.mightDrag.addAttr && (this.target.draggable = !0), this.mightDrag.setUneditable && setTimeout(() => { this.view.input.mouseDown == this && this.target.setAttribute('contentEditable', 'false') }, 20), this.view.domObserver.start()), e.root.addEventListener('mouseup', this.up = this.up.bind(this)), e.root.addEventListener('mousemove', this.move = this.move.bind(this)), xt(e, 'pointer')
  }

  done() { this.view.root.removeEventListener('mouseup', this.up), this.view.root.removeEventListener('mousemove', this.move), this.mightDrag && this.target && (this.view.domObserver.stop(), this.mightDrag.addAttr && this.target.removeAttribute('draggable'), this.mightDrag.setUneditable && this.target.removeAttribute('contentEditable'), this.view.domObserver.start()), this.delayedSelectionSync && setTimeout(() => mo(this.view)), this.view.input.mouseDown = null }up(e) {
    if (this.done(), !this.view.dom.contains(e.target))
      return; let t = this.pos; this.view.state.doc != this.startDoc && (t = this.view.posAtCoords(Yr(e))), this.updateAllowDefault(e), this.allowDefault || !t ? xt(this.view, 'pointer') : pm(this.view, t.pos, t.inside, e, this.selectNode) ? e.preventDefault() : e.button == 0 && (this.flushed || Xt && this.mightDrag && !this.mightDrag.node.isAtom || Qt && !this.view.state.selection.visible && Math.min(Math.abs(t.pos - this.view.state.selection.from), Math.abs(t.pos - this.view.state.selection.to)) <= 2) ? (xn(this.view, M.near(this.view.state.doc.resolve(t.pos)), 'pointer'), e.preventDefault()) : xt(this.view, 'pointer')
  }

  move(e) { this.updateAllowDefault(e), xt(this.view, 'pointer'), e.buttons == 0 && this.done() }updateAllowDefault(e) { !this.allowDefault && (Math.abs(this.event.x - e.clientX) > 4 || Math.abs(this.event.y - e.clientY) > 4) && (this.allowDefault = !0) }
}; Ie.touchstart = (n) => { n.input.lastTouch = Date.now(), yo(n), xt(n, 'pointer') }; Ie.touchmove = (n) => { n.input.lastTouch = Date.now(), xt(n, 'pointer') }; Ie.contextmenu = n => yo(n); function nc(n, e) { return n.composing ? !0 : Xt && Math.abs(e.timeStamp - n.input.compositionEndedAt) < 500 ? (n.input.compositionEndedAt = -2e8, !0) : !1 } const Dm = rr ? 5e3 : -1; Se.compositionstart = Se.compositionupdate = (n) => {
  if (!n.composing) {
    n.domObserver.flush(); const { state: e } = n; const t = e.selection.$from; if (e.selection.empty && (e.storedMarks || !t.textOffset && t.parentOffset && t.nodeBefore.marks.some(r => r.type.spec.inclusive === !1))) { n.markCursor = n.state.storedMarks || t.marks(), Jr(n, !0), n.markCursor = null }
    else if (Jr(n), Gr && e.selection.empty && t.parentOffset && !t.textOffset && t.nodeBefore.marks.length) {
      const r = n.domSelection(); for (let i = r.focusNode, s = r.focusOffset; i && i.nodeType == 1 && s != 0;) {
        const o = s < 0 ? i.lastChild : i.childNodes[s - 1]; if (!o)
          break; if (o.nodeType == 3) { r.collapse(o, o.nodeValue.length); break }
        else { i = o, s = -1 }
      }
    }n.input.composing = !0
  }rc(n, Dm)
}; Se.compositionend = (n, e) => { n.composing && (n.input.composing = !1, n.input.compositionEndedAt = e.timeStamp, rc(n, 20)) }; function rc(n, e) { clearTimeout(n.input.composingTimeout), e > -1 && (n.input.composingTimeout = setTimeout(() => Jr(n), e)) } function bm(n) { for (n.composing && (n.input.composing = !1, n.input.compositionEndedAt = Cm()); n.input.compositionNodes.length > 0;)n.input.compositionNodes.pop().markParentsDirty() } function Cm() { const n = document.createEvent('Event'); return n.initEvent('event', !0, !0), n.timeStamp } function Jr(n, e = !1) { if (!(rr && n.domObserver.flushingSoon >= 0)) { if (n.domObserver.forceFlush(), bm(n), e || n.docView && n.docView.dirty) { const t = Xp(n); return t && !t.eq(n.state.selection) ? n.dispatch(n.state.tr.setSelection(t)) : n.updateState(n.state), !0 } return !1 } } function km(n, e) {
  if (!n.dom.parentNode)
    return; const t = n.dom.parentNode.appendChild(document.createElement('div')); t.appendChild(e), t.style.cssText = 'position: fixed; left: -10000px; top: 10px'; const r = getSelection(); const i = document.createRange(); i.selectNodeContents(e), n.dom.blur(), r.removeAllRanges(), r.addRange(i), setTimeout(() => { t.parentNode && t.parentNode.removeChild(t), n.focus() }, 50)
} const En = An && fo < 15 || ho && Jp < 604; Ie.copy = Se.cut = (n, e) => {
  const t = e; const r = n.state.selection; const i = t.type == 'cut'; if (r.empty)
    return; const s = En ? null : t.clipboardData; const o = r.content(); const { dom: l, text: a } = Uu(n, o); s ? (t.preventDefault(), s.clearData(), s.setData('text/html', l.innerHTML), s.setData('text/plain', a)) : km(n, l), i && n.dispatch(n.state.tr.deleteSelection().scrollIntoView().setMeta('uiEvent', 'cut'))
}; function Sm(n) { return n.openStart == 0 && n.openEnd == 0 && n.content.childCount == 1 ? n.content.firstChild : null } function xm(n, e) {
  if (!n.dom.parentNode)
    return; const t = n.input.shiftKey || n.state.selection.$from.parent.type.spec.code; const r = n.dom.parentNode.appendChild(document.createElement(t ? 'textarea' : 'div')); t || (r.contentEditable = 'true'), r.style.cssText = 'position: fixed; left: -10000px; top: 10px', r.focus(), setTimeout(() => { n.focus(), r.parentNode && r.parentNode.removeChild(r), t ? uo(n, r.value, null, e) : uo(n, r.textContent, r.innerHTML, e) }, 50)
} function uo(n, e, t, r) {
  const i = Gu(n, e, t, n.input.shiftKey, n.state.selection.$from); if (n.someProp('handlePaste', l => l(n, r, i || b.empty)))
    return !0; if (!i)
    return !1; const s = Sm(i); const o = s ? n.state.tr.replaceSelectionWith(s, n.input.shiftKey) : n.state.tr.replaceSelection(i); return n.dispatch(o.scrollIntoView().setMeta('paste', !0).setMeta('uiEvent', 'paste')), !0
}Se.paste = (n, e) => {
  const t = e; if (n.composing && !rr)
    return; const r = En ? null : t.clipboardData; r && uo(n, r.getData('text/plain'), r.getData('text/html'), t) ? t.preventDefault() : xm(n, t)
}; const co = class {constructor(e, t) { this.slice = e, this.move = t }}; const ic = we ? 'altKey' : 'ctrlKey'; Ie.dragstart = (n, e) => {
  const t = e; const r = n.input.mouseDown; if (r && r.done(), !t.dataTransfer)
    return; const i = n.state.selection; const s = i.empty ? null : n.posAtCoords(Yr(t)); if (!(s && s.pos >= i.from && s.pos <= (i instanceof k ? i.to - 1 : i.to))) {
    if (r && r.mightDrag) { n.dispatch(n.state.tr.setSelection(k.create(n.state.doc, r.mightDrag.pos))) }
    else if (t.target && t.target.nodeType == 1) { const u = n.docView.nearestDesc(t.target, !0); u && u.node.type.spec.draggable && u != n.docView && n.dispatch(n.state.tr.setSelection(k.create(n.state.doc, u.posBefore))) }
  }
  const o = n.state.selection.content(); const { dom: l, text: a } = Uu(n, o); t.dataTransfer.clearData(), t.dataTransfer.setData(En ? 'Text' : 'text/html', l.innerHTML), t.dataTransfer.effectAllowed = 'copyMove', En || t.dataTransfer.setData('text/plain', a), n.dragging = new co(o, !t[ic])
}; Ie.dragend = (n) => { const e = n.dragging; window.setTimeout(() => { n.dragging == e && (n.dragging = null) }, 50) }; Se.dragover = Se.dragenter = (n, e) => e.preventDefault(); Se.drop = (n, e) => {
  const t = e; const r = n.dragging; if (n.dragging = null, !t.dataTransfer)
    return; const i = n.posAtCoords(Yr(t)); if (!i)
    return; const s = n.state.doc.resolve(i.pos); let o = r && r.slice; o ? n.someProp('transformPasted', (p) => { o = p(o) }) : o = Gu(n, t.dataTransfer.getData(En ? 'Text' : 'text/plain'), En ? null : t.dataTransfer.getData('text/html'), !1, s); const l = !!(r && !t[ic]); if (n.someProp('handleDrop', p => p(n, t, o || b.empty, l))) { t.preventDefault(); return } if (!o)
    return; t.preventDefault(); let a = o ? Wr(n.state.doc, s.pos, o) : s.pos; a == null && (a = s.pos); const u = n.state.tr; l && u.deleteSelection(); const c = u.mapping.map(a); const d = o.openStart == 0 && o.openEnd == 0 && o.content.childCount == 1; const f = u.doc; if (d ? u.replaceRangeWith(c, c, o.content.firstChild) : u.replaceRange(c, c, o), u.doc.eq(f))
    return; const h = u.doc.resolve(c); if (d && k.isSelectable(o.content.firstChild) && h.nodeAfter && h.nodeAfter.sameMarkup(o.content.firstChild)) { u.setSelection(new k(h)) }
  else { let p = u.mapping.map(a); u.mapping.maps[u.mapping.maps.length - 1].forEach((m, g, D, S) => p = S), u.setSelection(_u(n, h, u.doc.resolve(p))) }n.focus(), n.dispatch(u.setMeta('uiEvent', 'drop'))
}; Ie.focus = (n) => { n.input.lastFocus = Date.now(), n.focused || (n.domObserver.stop(), n.dom.classList.add('ProseMirror-focused'), n.domObserver.start(), n.focused = !0, setTimeout(() => { n.docView && n.hasFocus() && !n.domObserver.currentSelection.eq(n.domSelection()) && mo(n) }, 20)) }; Ie.blur = (n, e) => { const t = e; n.focused && (n.domObserver.stop(), n.dom.classList.remove('ProseMirror-focused'), n.domObserver.start(), t.relatedTarget && n.dom.contains(t.relatedTarget) && n.domObserver.currentSelection.clear(), n.focused = !1) }; Ie.beforeinput = (n, e) => {
  if (Qt && rr && e.inputType == 'deleteContentBackward') {
    n.domObserver.flushSoon(); const { domChangeCount: r } = n.input; setTimeout(() => {
      if (n.input.domChangeCount != r || (n.dom.blur(), n.focus(), n.someProp('handleKeyDown', s => s(n, ju(8, 'Backspace')))))
        return; const { $cursor: i } = n.state.selection; i && i.pos > 0 && n.dispatch(n.state.tr.delete(i.pos - 1, i.pos).scrollIntoView())
    }, 50)
  }
}; for (const n in Se)Ie[n] = Se[n]; function er(n, e) {
  if (n == e)
    return !0; for (const t in n) {
    if (n[t] !== e[t])
      return !1
  } for (const t in e) {
    if (!(t in n))
      return !1
  } return !0
} var tr = class {constructor(e, t) { this.toDOM = e, this.spec = t || Gt, this.side = this.spec.side || 0 }map(e, t, r, i) { const { pos: s, deleted: o } = e.mapResult(t.from + i, this.side < 0 ? -1 : 1); return o ? null : new ke(s - r, s - r, this) }valid() { return !0 }eq(e) { return this == e || e instanceof tr && (this.spec.key && this.spec.key == e.spec.key || this.toDOM == e.toDOM && er(this.spec, e.spec)) }destroy(e) { this.spec.destroy && this.spec.destroy(e) }}; var Je = class {constructor(e, t) { this.attrs = e, this.spec = t || Gt }map(e, t, r, i) { const s = e.map(t.from + i, this.spec.inclusiveStart ? -1 : 1) - r; const o = e.map(t.to + i, this.spec.inclusiveEnd ? 1 : -1) - r; return s >= o ? null : new ke(s, o, this) }valid(e, t) { return t.from < t.to }eq(e) { return this == e || e instanceof Je && er(this.attrs, e.attrs) && er(this.spec, e.spec) } static is(e) { return e.type instanceof Je }destroy() {}}; var nr = class {
  constructor(e, t) { this.attrs = e, this.spec = t || Gt }map(e, t, r, i) {
    const s = e.mapResult(t.from + i, 1); if (s.deleted)
      return null; const o = e.mapResult(t.to + i, -1); return o.deleted || o.pos <= s.pos ? null : new ke(s.pos - r, o.pos - r, this)
  }

  valid(e, t) { const { index: r, offset: i } = e.content.findIndex(t.from); let s; return i == t.from && !(s = e.child(r)).isText && i + s.nodeSize == t.to }eq(e) { return this == e || e instanceof nr && er(this.attrs, e.attrs) && er(this.spec, e.spec) }destroy() {}
}; var ke = class {constructor(e, t, r) { this.from = e, this.to = t, this.type = r }copy(e, t) { return new ke(e, t, this.type) }eq(e, t = 0) { return this.type.eq(e.type) && this.from + t == e.from && this.to + t == e.to }map(e, t, r) { return this.type.map(e, this, t, r) } static widget(e, t, r) { return new ke(e, e, new tr(t, r)) } static inline(e, t, r, i) { return new ke(e, t, new Je(r, i)) } static node(e, t, r, i) { return new ke(e, t, new nr(r, i)) } get spec() { return this.type.spec } get inline() { return this.type instanceof Je }}; const Sn = []; var Gt = {}; var J = class {
  constructor(e, t) { this.local = e.length ? e : Sn, this.children = t.length ? t : Sn } static create(e, t) { return t.length ? Ur(t, e, 0, Gt) : de }find(e, t, r) { const i = []; return this.findInner(e ?? 0, t ?? 1e9, i, 0, r), i }findInner(e, t, r, i, s) { for (let o = 0; o < this.local.length; o++) { const l = this.local[o]; l.from <= t && l.to >= e && (!s || s(l.spec)) && r.push(l.copy(l.from + i, l.to + i)) } for (let o = 0; o < this.children.length; o += 3) if (this.children[o] < t && this.children[o + 1] > e) { const l = this.children[o] + 1; this.children[o + 2].findInner(e - l, t - l, r, i + l, s) } }map(e, t, r) { return this == de || e.maps.length == 0 ? this : this.mapInner(e, t, 0, 0, r || Gt) }mapInner(e, t, r, i, s) { let o; for (let l = 0; l < this.local.length; l++) { const a = this.local[l].map(e, r, i); a && a.type.valid(t, a) ? (o || (o = [])).push(a) : s.onRemove && s.onRemove(this.local[l].spec) } return this.children.length ? Em(this.children, o || [], e, t, r, i, s) : o ? new J(o.sort(Yt), Sn) : de }add(e, t) { return t.length ? this == de ? J.create(e, t) : this.addInner(e, t, 0) : this }addInner(e, t, r) { let i; let s = 0; e.forEach((l, a) => { const u = a + r; let c; if (c = oc(t, l, u)) { for (i || (i = this.children.slice()); s < i.length && i[s] < a;)s += 3; i[s] == a ? i[s + 2] = i[s + 2].addInner(l, c, u + 1) : i.splice(s, 0, a, a + l.nodeSize, Ur(c, l, u + 1, Gt)), s += 3 } }); const o = sc(s ? lc(t) : t, -r); for (let l = 0; l < o.length; l++)o[l].type.valid(e, o[l]) || o.splice(l--, 1); return new J(o.length ? this.local.concat(o).sort(Yt) : this.local, i || this.children) }remove(e) { return e.length == 0 || this == de ? this : this.removeInner(e, 0) }removeInner(e, t) {
    let r = this.children; let i = this.local; for (let s = 0; s < r.length; s += 3) {
      let o; const l = r[s] + t; const a = r[s + 1] + t; for (let c = 0, d; c < e.length; c++)(d = e[c]) && d.from > l && d.to < a && (e[c] = null, (o || (o = [])).push(d)); if (!o)
        continue; r == this.children && (r = this.children.slice()); const u = r[s + 2].removeInner(o, l + 1); u != de ? r[s + 2] = u : (r.splice(s, 3), s -= 3)
    } if (i.length) {
      for (let s = 0, o; s < e.length; s++) {
        if (o = e[s])
          for (let l = 0; l < i.length; l++)i[l].eq(o, t) && (i == this.local && (i = this.local.slice()), i.splice(l--, 1))
      }
    } return r == this.children && i == this.local ? this : i.length || r.length ? new J(i, r) : de
  }

  forChild(e, t) {
    if (this == de)
      return this; if (t.isLeaf)
      return J.empty; let r, i; for (let l = 0; l < this.children.length; l += 3) if (this.children[l] >= e) { this.children[l] == e && (r = this.children[l + 2]); break } const s = e + 1; const o = s + t.content.size; for (let l = 0; l < this.local.length; l++) { const a = this.local[l]; if (a.from < o && a.to > s && a.type instanceof Je) { const u = Math.max(s, a.from) - s; const c = Math.min(o, a.to) - s; u < c && (i || (i = [])).push(a.copy(u, c)) } } if (i) { const l = new J(i.sort(Yt), Sn); return r ? new ot([l, r]) : l } return r || de
  }

  eq(e) {
    if (this == e)
      return !0; if (!(e instanceof J) || this.local.length != e.local.length || this.children.length != e.children.length)
      return !1; for (let t = 0; t < this.local.length; t++) {
      if (!this.local[t].eq(e.local[t]))
        return !1
    } for (let t = 0; t < this.children.length; t += 3) {
      if (this.children[t] != e.children[t] || this.children[t + 1] != e.children[t + 1] || !this.children[t + 2].eq(e.children[t + 2]))
        return !1
    } return !0
  }

  locals(e) { return Do(this.localsInner(e)) }localsInner(e) {
    if (this == de)
      return Sn; if (e.inlineContent || !this.local.some(Je.is))
      return this.local; const t = []; for (let r = 0; r < this.local.length; r++) this.local[r].type instanceof Je || t.push(this.local[r]); return t
  }
}; J.empty = new J([], []); J.removeOverlap = Do; var de = J.empty; var ot = class {
  constructor(e) { this.members = e }map(e, t) { const r = this.members.map(i => i.map(e, t, Gt)); return ot.from(r) }forChild(e, t) {
    if (t.isLeaf)
      return J.empty; let r = []; for (let i = 0; i < this.members.length; i++) { const s = this.members[i].forChild(e, t); s != de && (s instanceof ot ? r = r.concat(s.members) : r.push(s)) } return ot.from(r)
  }

  eq(e) {
    if (!(e instanceof ot) || e.members.length != this.members.length)
      return !1; for (let t = 0; t < this.members.length; t++) {
      if (!this.members[t].eq(e.members[t]))
        return !1
    } return !0
  }

  locals(e) {
    let t; let r = !0; for (let i = 0; i < this.members.length; i++) {
      const s = this.members[i].localsInner(e); if (s.length)
        if (!t) { t = s }
 else { r && (t = t.slice(), r = !1); for (let o = 0; o < s.length; o++)t.push(s[o]) }
    } return t ? Do(r ? t : t.sort(Yt)) : Sn
  }

  static from(e) { switch (e.length) { case 0:return de; case 1:return e[0]; default:return new ot(e) } }
}; function Em(n, e, t, r, i, s, o) {
  const l = n.slice(); for (let u = 0, c = s; u < t.maps.length; u++) {
    let d = 0; t.maps[u].forEach((f, h, p, m) => {
      const g = m - p - (h - f); for (let D = 0; D < l.length; D += 3) {
        const S = l[D + 1]; if (S < 0 || f > S + c - d)
          continue; const F = l[D] + c - d; h >= F ? l[D + 1] = f <= F ? -2 : -1 : p >= i && g && (l[D] += g, l[D + 1] += g)
      }d += g
    }), c = t.maps[u].map(c, -1)
  } let a = !1; for (let u = 0; u < l.length; u += 3) {
    if (l[u + 1] < 0) {
      if (l[u + 1] == -2) { a = !0, l[u + 1] = -1; continue } const c = t.map(n[u] + s); const d = c - i; if (d < 0 || d >= r.content.size) { a = !0; continue } const f = t.map(n[u + 1] + s, -1); const h = f - i; const { index: p, offset: m } = r.content.findIndex(d); const g = r.maybeChild(p); if (g && m == d && m + g.nodeSize == h) { const D = l[u + 2].mapInner(t, g, c + 1, n[u] + s + 1, o); D != de ? (l[u] = d, l[u + 1] = h, l[u + 2] = D) : (l[u + 1] = -2, a = !0) }
      else { a = !0 }
    }
  } if (a) { const u = Am(l, n, e, t, i, s, o); const c = Ur(u, r, 0, o); e = c.local; for (let d = 0; d < l.length; d += 3)l[d + 1] < 0 && (l.splice(d, 3), d -= 3); for (let d = 0, f = 0; d < c.children.length; d += 3) { const h = c.children[d]; for (;f < l.length && l[f] < h;)f += 3; l.splice(f, 0, c.children[d], c.children[d + 1], c.children[d + 2]) } } return new J(e.sort(Yt), l)
} function sc(n, e) {
  if (!e || !n.length)
    return n; const t = []; for (let r = 0; r < n.length; r++) { const i = n[r]; t.push(new ke(i.from + e, i.to + e, i.type)) } return t
} function Am(n, e, t, r, i, s, o) { function l(a, u) { for (let c = 0; c < a.local.length; c++) { const d = a.local[c].map(r, i, u); d ? t.push(d) : o.onRemove && o.onRemove(a.local[c].spec) } for (let c = 0; c < a.children.length; c += 3)l(a.children[c + 2], a.children[c] + u + 1) } for (let a = 0; a < n.length; a += 3)n[a + 1] == -1 && l(n[a + 2], e[a] + s + 1); return t } function oc(n, e, t) {
  if (e.isLeaf)
    return null; const r = t + e.nodeSize; let i = null; for (let s = 0, o; s < n.length; s++)(o = n[s]) && o.from > t && o.to < r && ((i || (i = [])).push(o), n[s] = null); return i
} function lc(n) { const e = []; for (let t = 0; t < n.length; t++)n[t] != null && e.push(n[t]); return e } function Ur(n, e, t, r) { const i = []; let s = !1; e.forEach((l, a) => { const u = oc(n, l, a + t); if (u) { s = !0; const c = Ur(u, l, t + a + 1, r); c != de && i.push(a, a + l.nodeSize, c) } }); const o = sc(s ? lc(n) : n, -t).sort(Yt); for (let l = 0; l < o.length; l++)o[l].type.valid(e, o[l]) || (r.onRemove && r.onRemove(o[l].spec), o.splice(l--, 1)); return o.length || i.length ? new J(o, i) : de } function Yt(n, e) { return n.from - e.from || n.to - e.to } function Do(n) {
  let e = n; for (let t = 0; t < e.length - 1; t++) {
    const r = e[t]; if (r.from != r.to) {
      for (let i = t + 1; i < e.length; i++) {
        const s = e[i]; if (s.from == r.from) { s.to != r.to && (e == n && (e = n.slice()), e[i] = s.copy(s.from, r.to), Hu(e, i + 1, s.copy(r.to, s.to))); continue }
        else { s.from < r.to && (e == n && (e = n.slice()), e[t] = r.copy(r.from, s.from), Hu(e, i, r.copy(s.from, r.to))); break }
      }
    }
  } return e
} function Hu(n, e, t) { for (;e < n.length && Yt(t, n[e]) > 0;)e++; n.splice(e, 0, t) } const z0 = An && fo <= 11; var V = class extends M {
  constructor(e) { super(e, e) }map(e, t) { const r = e.resolve(t.map(this.head)); return V.valid(r) ? new V(r) : M.near(r) }content() { return b.empty }eq(e) { return e instanceof V && e.head == this.head }toJSON() { return { type: 'gapcursor', pos: this.head } } static fromJSON(e, t) {
    if (typeof t.pos != 'number')
      throw new RangeError('Invalid input for GapCursor.fromJSON'); return new V(e.resolve(t.pos))
  }

  getBookmark() { return new sr(this.anchor) } static valid(e) {
    const t = e.parent; if (t.isTextblock || !Mm(e) || !Om(e))
      return !1; const r = t.type.spec.allowGapCursor; if (r != null)
      return r; const i = t.contentMatchAt(e.index()).defaultType; return i && i.isTextblock
  }

  static findGapCursorFrom(e, t, r = !1) {
    e:for (;;) {
      if (!r && V.valid(e))
        return e; let i = e.pos; let s = null; for (let o = e.depth; ;o--) {
        const l = e.node(o); if (t > 0 ? e.indexAfter(o) < l.childCount : e.index(o) > 0) { s = l.child(t > 0 ? e.indexAfter(o) : e.index(o) - 1); break }
        else if (o == 0) { return null } i += t; const a = e.doc.resolve(i); if (V.valid(a))
          return a
      } for (;;) {
        const o = t > 0 ? s.firstChild : s.lastChild; if (!o) { if (s.isAtom && !s.isText && !k.isSelectable(s)) { e = e.doc.resolve(i + s.nodeSize * t), r = !1; continue e } break }s = o, i += t; const l = e.doc.resolve(i); if (V.valid(l))
          return l
      } return null
    }
  }
}; V.prototype.visible = !1; V.findFrom = V.findGapCursorFrom; M.jsonID('gapcursor', V); var sr = class {constructor(e) { this.pos = e }map(e) { return new sr(e.map(this.pos)) }resolve(e) { const t = e.resolve(this.pos); return V.valid(t) ? new V(t) : M.near(t) }}; function Mm(n) {
  for (let e = n.depth; e >= 0; e--) {
    const t = n.index(e); const r = n.node(e); if (t == 0) {
      if (r.type.spec.isolating)
        return !0; continue
    } for (let i = r.child(t - 1); ;i = i.lastChild) {
      if (i.childCount == 0 && !i.inlineContent || i.isAtom || i.type.spec.isolating)
        return !0; if (i.inlineContent)
        return !1
    }
  } return !0
} function Om(n) {
  for (let e = n.depth; e >= 0; e--) {
    const t = n.indexAfter(e); const r = n.node(e); if (t == r.childCount) {
      if (r.type.spec.isolating)
        return !0; continue
    } for (let i = r.child(t); ;i = i.firstChild) {
      if (i.childCount == 0 && !i.inlineContent || i.isAtom || i.type.spec.isolating)
        return !0; if (i.inlineContent)
        return !1
    }
  } return !0
} function ac() { return new L({ props: { decorations: Fm, createSelectionBetween(n, e, t) { return e.pos == t.pos && V.valid(t) ? new V(t) : null }, handleClick: Nm, handleKeyDown: Tm, handleDOMEvents: { beforeinput: wm } } }) } var Tm = ks({ ArrowLeft: Qr('horiz', -1), ArrowRight: Qr('horiz', 1), ArrowUp: Qr('vert', -1), ArrowDown: Qr('vert', 1) }); function Qr(n, e) {
  const t = n == 'vert' ? e > 0 ? 'down' : 'up' : e > 0 ? 'right' : 'left'; return function (r, i, s) {
    const o = r.selection; let l = e > 0 ? o.$to : o.$from; let a = o.empty; if (o instanceof E) {
      if (!s.endOfTextblock(t) || l.depth == 0)
        return !1; a = !1, l = r.doc.resolve(e > 0 ? l.after() : l.before())
    } const u = V.findGapCursorFrom(l, e, a); return u ? (i && i(r.tr.setSelection(new V(u))), !0) : !1
  }
} function Nm(n, e, t) {
  if (!n || !n.editable)
    return !1; const r = n.state.doc.resolve(e); if (!V.valid(r))
    return !1; const i = n.posAtCoords({ left: t.clientX, top: t.clientY }); return i && i.inside > -1 && k.isSelectable(n.state.doc.nodeAt(i.inside)) ? !1 : (n.dispatch(n.state.tr.setSelection(new V(r))), !0)
} function wm(n, e) {
  if (e.inputType != 'insertCompositionText' || !(n.state.selection instanceof V))
    return !1; const { $from: t } = n.state.selection; const r = t.parent.contentMatchAt(t.index()).findWrapping(n.state.schema.nodes.text); if (!r)
    return !1; let i = y.empty; for (let o = r.length - 1; o >= 0; o--)i = y.from(r[o].createAndFill(null, i)); const s = n.state.tr.replace(t.pos, t.pos, new b(i, 0, 0)); return s.setSelection(E.near(s.doc.resolve(t.pos + 1))), n.dispatch(s), !1
} function Fm(n) {
  if (!(n.selection instanceof V))
    return null; const e = document.createElement('div'); return e.className = 'ProseMirror-gapcursor', J.create(n.doc, [ke.widget(n.selection.head, e, { key: 'gapcursor' })])
} const uc = H.create({ name: 'gapCursor', addProseMirrorPlugins() { return [ac()] }, extendNodeSchema(n) { let e; const t = { name: n.name, options: n.options, storage: n.storage }; return { allowGapCursor: (e = T(x(n, 'allowGapCursor', t))) !== null && e !== void 0 ? e : null } } }); const cc = R.create({
  name: 'hardBreak',
  addOptions() { return { keepMarks: !0, HTMLAttributes: {} } },
  inline: !0,
  group: 'inline',
  selectable: !1,
  parseHTML() { return [{ tag: 'br' }] },
  renderHTML({ HTMLAttributes: n }) { return ['br', v(this.options.HTMLAttributes, n)] },
  renderText() {
    return `
`
  },
  addCommands() {
    return {
      setHardBreak: () => ({ commands: n, chain: e, state: t, editor: r }) => n.first([() => n.exitCode(), () => n.command(() => {
        const { selection: i, storedMarks: s } = t; if (i.$from.parent.type.spec.isolating)
          return !1; const { keepMarks: o } = this.options; const { splittableMarks: l } = r.extensionManager; const a = s || i.$to.parentOffset && i.$from.marks(); return e().insertContent({ type: this.name }).command(({ tr: u, dispatch: c }) => { if (c && a && o) { const d = a.filter(f => l.includes(f.type.name)); u.ensureMarks(d) } return !0 }).run()
      })]),
    }
  },
  addKeyboardShortcuts() { return { 'Mod-Enter': () => this.editor.commands.setHardBreak(), 'Shift-Enter': () => this.editor.commands.setHardBreak() } },
}); const dc = R.create({ name: 'heading', addOptions() { return { levels: [1, 2, 3, 4, 5, 6], HTMLAttributes: {} } }, content: 'inline*', group: 'block', defining: !0, addAttributes() { return { level: { default: 1, rendered: !1 } } }, parseHTML() { return this.options.levels.map(n => ({ tag: `h${n}`, attrs: { level: n } })) }, renderHTML({ node: n, HTMLAttributes: e }) { return [`h${this.options.levels.includes(n.attrs.level) ? n.attrs.level : this.options.levels[0]}`, v(this.options.HTMLAttributes, e), 0] }, addCommands() { return { setHeading: n => ({ commands: e }) => this.options.levels.includes(n.level) ? e.setNode(this.name, n) : !1, toggleHeading: n => ({ commands: e }) => this.options.levels.includes(n.level) ? e.toggleNode(this.name, 'paragraph', n) : !1 } }, addKeyboardShortcuts() { return this.options.levels.reduce((n, e) => ({ ...n, [`Mod-Alt-${e}`]: () => this.editor.commands.toggleHeading({ level: e }) }), {}) }, addInputRules() { return this.options.levels.map(n => Yn({ find: new RegExp(`^(#{1,${n}})\\s$`), type: this.type, getAttributes: { level: n } })) } }); const Xr = 200; const Z = function () {}; Z.prototype.append = function (e) { return e.length ? (e = Z.from(e), !this.length && e || e.length < Xr && this.leafAppend(e) || this.length < Xr && e.leafPrepend(this) || this.appendInner(e)) : this }; Z.prototype.prepend = function (e) { return e.length ? Z.from(e).append(this) : this }; Z.prototype.appendInner = function (e) { return new vm(this, e) }; Z.prototype.slice = function (e, t) { return e === void 0 && (e = 0), t === void 0 && (t = this.length), e >= t ? Z.empty : this.sliceInner(Math.max(0, e), Math.min(this.length, t)) }; Z.prototype.get = function (e) {
  if (!(e < 0 || e >= this.length))
    return this.getInner(e)
}; Z.prototype.forEach = function (e, t, r) { t === void 0 && (t = 0), r === void 0 && (r = this.length), t <= r ? this.forEachInner(e, t, r, 0) : this.forEachInvertedInner(e, t, r, 0) }; Z.prototype.map = function (e, t, r) { t === void 0 && (t = 0), r === void 0 && (r = this.length); const i = []; return this.forEach((s, o) => { return i.push(e(s, o)) }, t, r), i }; Z.from = function (e) { return e instanceof Z ? e : e && e.length ? new fc(e) : Z.empty }; var fc = (function (n) {
  function e(r) { n.call(this), this.values = r }n && (e.__proto__ = n), e.prototype = Object.create(n && n.prototype), e.prototype.constructor = e; const t = { length: { configurable: !0 }, depth: { configurable: !0 } }; return e.prototype.flatten = function () { return this.values }, e.prototype.sliceInner = function (i, s) { return i == 0 && s == this.length ? this : new e(this.values.slice(i, s)) }, e.prototype.getInner = function (i) { return this.values[i] }, e.prototype.forEachInner = function (i, s, o, l) {
    for (let a = s; a < o; a++) {
      if (i(this.values[a], l + a) === !1)
        return !1
    }
  }, e.prototype.forEachInvertedInner = function (i, s, o, l) {
    for (let a = s - 1; a >= o; a--) {
      if (i(this.values[a], l + a) === !1)
        return !1
    }
  }, e.prototype.leafAppend = function (i) {
    if (this.length + i.length <= Xr)
      return new e(this.values.concat(i.flatten()))
  }, e.prototype.leafPrepend = function (i) {
    if (this.length + i.length <= Xr)
      return new e(i.flatten().concat(this.values))
  }, t.length.get = function () { return this.values.length }, t.depth.get = function () { return 0 }, Object.defineProperties(e.prototype, t), e
}(Z)); Z.empty = new fc([]); var vm = (function (n) {
  function e(t, r) { n.call(this), this.left = t, this.right = r, this.length = t.length + r.length, this.depth = Math.max(t.depth, r.depth) + 1 } return n && (e.__proto__ = n), e.prototype = Object.create(n && n.prototype), e.prototype.constructor = e, e.prototype.flatten = function () { return this.left.flatten().concat(this.right.flatten()) }, e.prototype.getInner = function (r) { return r < this.left.length ? this.left.get(r) : this.right.get(r - this.left.length) }, e.prototype.forEachInner = function (r, i, s, o) {
    const l = this.left.length; if (i < l && this.left.forEachInner(r, i, Math.min(s, l), o) === !1 || s > l && this.right.forEachInner(r, Math.max(i - l, 0), Math.min(this.length, s) - l, o + l) === !1)
      return !1
  }, e.prototype.forEachInvertedInner = function (r, i, s, o) {
    const l = this.left.length; if (i > l && this.right.forEachInvertedInner(r, i - l, Math.max(s, l) - l, o + l) === !1 || s < l && this.left.forEachInvertedInner(r, Math.min(i, l), s, o) === !1)
      return !1
  }, e.prototype.sliceInner = function (r, i) {
    if (r == 0 && i == this.length)
      return this; const s = this.left.length; return i <= s ? this.left.slice(r, i) : r >= s ? this.right.slice(r - s, i - s) : this.left.slice(r, s).append(this.right.slice(0, i - s))
  }, e.prototype.leafAppend = function (r) {
    const i = this.right.leafAppend(r); if (i)
      return new e(this.left, i)
  }, e.prototype.leafPrepend = function (r) {
    const i = this.left.leafPrepend(r); if (i)
      return new e(i, this.right)
  }, e.prototype.appendInner = function (r) { return this.left.depth >= Math.max(this.right.depth, r.depth) + 1 ? new e(this.left, new e(this.right, r)) : new e(this, r) }, e
}(Z)); const Bm = Z; const bo = Bm; const Im = 500; var xe = class {
  constructor(e, t) { this.items = e, this.eventCount = t }popEvent(e, t) {
    if (this.eventCount == 0)
      return null; let r = this.items.length; for (;;r--) if (this.items.get(r - 1).selection) { --r; break } let i, s; t && (i = this.remapping(r, this.items.length), s = i.maps.length); const o = e.tr; let l; let a; const u = []; const c = []; return this.items.forEach((d, f) => {
      if (!d.step) { i || (i = this.remapping(r, f + 1), s = i.maps.length), s--, c.push(d); return } if (i) { c.push(new Fe(d.map)); const h = d.step.map(i.slice(s)); let p; h && o.maybeStep(h).doc && (p = o.mapping.maps[o.mapping.maps.length - 1], u.push(new Fe(p, void 0, void 0, u.length + c.length))), s--, p && i.appendMap(p, s) }
      else { o.maybeStep(d.step) } if (d.selection)
        return l = i ? d.selection.map(i.slice(s)) : d.selection, a = new xe(this.items.slice(0, r).append(c.reverse().concat(u)), this.eventCount - 1), !1
    }, this.items.length, 0), { remaining: a, transform: o, selection: l }
  }

  addTransform(e, t, r, i) { const s = []; let o = this.eventCount; let l = this.items; let a = !i && l.length ? l.get(l.length - 1) : null; for (let c = 0; c < e.steps.length; c++) { const d = e.steps[c].invert(e.docs[c]); let f = new Fe(e.mapping.maps[c], d, t); let h; (h = a && a.merge(f)) && (f = h, c ? s.pop() : l = l.slice(0, l.length - 1)), s.push(f), t && (o++, t = void 0), i || (a = f) } const u = o - r.depth; return u > Rm && (l = Pm(l, u), o -= u), new xe(l.append(s), o) }remapping(e, t) { const r = new St(); return this.items.forEach((i, s) => { const o = i.mirrorOffset != null && s - i.mirrorOffset >= e ? r.maps.length - i.mirrorOffset : void 0; r.appendMap(i.map, o) }, e, t), r }addMaps(e) { return this.eventCount == 0 ? this : new xe(this.items.append(e.map(t => new Fe(t))), this.eventCount) }rebased(e, t) {
    if (!this.eventCount)
      return this; const r = []; const i = Math.max(0, this.items.length - t); const s = e.mapping; let o = e.steps.length; let l = this.eventCount; this.items.forEach((f) => { f.selection && l-- }, i); let a = t; this.items.forEach((f) => {
      const h = s.getMirror(--a); if (h == null)
        return; o = Math.min(o, h); const p = s.maps[h]; if (f.step) { const m = e.steps[h].invert(e.docs[h]); const g = f.selection && f.selection.map(s.slice(a + 1, h)); g && l++, r.push(new Fe(p, m, g)) }
      else { r.push(new Fe(p)) }
    }, i); const u = []; for (let f = t; f < o; f++)u.push(new Fe(s.maps[f])); const c = this.items.slice(0, i).append(u).append(r); let d = new xe(c, l); return d.emptyItemCount() > Im && (d = d.compress(this.items.length - r.length)), d
  }

  emptyItemCount() { let e = 0; return this.items.forEach((t) => { t.step || e++ }), e }compress(e = this.items.length) {
    const t = this.remapping(0, e); let r = t.maps.length; const i = []; let s = 0; return this.items.forEach((o, l) => {
      if (l >= e) { i.push(o), o.selection && s++ }
      else if (o.step) { const a = o.step.map(t.slice(r)); const u = a && a.getMap(); if (r--, u && t.appendMap(u, r), a) { const c = o.selection && o.selection.map(t.slice(r)); c && s++; const d = new Fe(u.invert(), a, c); let f; const h = i.length - 1; (f = i.length && i[h].merge(d)) ? i[h] = f : i.push(d) } }
      else { o.map && r-- }
    }, this.items.length, 0), new xe(bo.from(i.reverse()), s)
  }
}; xe.empty = new xe(bo.empty, 0); function Pm(n, e) {
  let t; return n.forEach((r, i) => {
    if (r.selection && e-- == 0)
      return t = i, !1
  }), n.slice(t)
} var Fe = class {
  constructor(e, t, r, i) { this.map = e, this.step = t, this.selection = r, this.mirrorOffset = i }merge(e) {
    if (this.step && e.step && !e.selection) {
      const t = e.step.merge(this.step); if (t)
        return new Fe(t.getMap().invert(), t, this.selection)
    }
  }
}; const Ue = class {constructor(e, t, r, i) { this.done = e, this.undone = t, this.prevRanges = r, this.prevTime = i }}; var Rm = 20; function Lm(n, e, t, r) {
  const i = t.getMeta(Mt); let s; if (i)
    return i.historyState; t.getMeta(Vm) && (n = new Ue(n.done, n.undone, null, 0)); const o = t.getMeta('appendedTransaction'); if (t.steps.length == 0)
    return n; if (o && o.getMeta(Mt))
    return o.getMeta(Mt).redo ? new Ue(n.done.addTransform(t, void 0, r, Zr(e)), n.undone, hc(t.mapping.maps[t.steps.length - 1]), n.prevTime) : new Ue(n.done, n.undone.addTransform(t, void 0, r, Zr(e)), null, n.prevTime); if (t.getMeta('addToHistory') !== !1 && !(o && o.getMeta('addToHistory') === !1)) { const l = n.prevTime == 0 || !o && (n.prevTime < (t.time || 0) - r.newGroupDelay || !zm(t, n.prevRanges)); const a = o ? Co(n.prevRanges, t.mapping) : hc(t.mapping.maps[t.steps.length - 1]); return new Ue(n.done.addTransform(t, l ? e.selection.getBookmark() : void 0, r, Zr(e)), xe.empty, a, t.time) }
  else { return (s = t.getMeta('rebased')) ? new Ue(n.done.rebased(t, s), n.undone.rebased(t, s), Co(n.prevRanges, t.mapping), n.prevTime) : new Ue(n.done.addMaps(t.mapping.maps), n.undone.addMaps(t.mapping.maps), Co(n.prevRanges, t.mapping), n.prevTime) }
} function zm(n, e) {
  if (!e)
    return !1; if (!n.docChanged)
    return !0; let t = !1; return n.mapping.maps[0].forEach((r, i) => { for (let s = 0; s < e.length; s += 2)r <= e[s + 1] && i >= e[s] && (t = !0) }), t
} function hc(n) { const e = []; return n.forEach((t, r, i, s) => e.push(i, s)), e } function Co(n, e) {
  if (!n)
    return null; const t = []; for (let r = 0; r < n.length; r += 2) { const i = e.map(n[r], 1); const s = e.map(n[r + 1], -1); i <= s && t.push(i, s) } return t
} function mc(n, e, t, r) {
  const i = Zr(e); const s = Mt.get(e).spec.config; const o = (r ? n.undone : n.done).popEvent(e, i); if (!o)
    return; const l = o.selection.resolve(o.transform.doc); const a = (r ? n.done : n.undone).addTransform(o.transform, e.selection.getBookmark(), s, i); const u = new Ue(r ? a : o.remaining, r ? o.remaining : a, null, 0); t(o.transform.setSelection(l).setMeta(Mt, { redo: r, historyState: u }).scrollIntoView())
} let ko = !1; let pc = null; function Zr(n) { const e = n.plugins; if (pc != e) { ko = !1, pc = e; for (let t = 0; t < e.length; t++) if (e[t].spec.historyPreserveItems) { ko = !0; break } } return ko } var Mt = new _('history'); var Vm = new _('closeHistory'); function gc(n = {}) { return n = { depth: n.depth || 100, newGroupDelay: n.newGroupDelay || 500 }, new L({ key: Mt, state: { init() { return new Ue(xe.empty, xe.empty, null, 0) }, apply(e, t, r) { return Lm(t, r, e, n) } }, config: n, props: { handleDOMEvents: { beforeinput(e, t) { const r = t.inputType; const i = r == 'historyUndo' ? So : r == 'historyRedo' ? xo : null; return i ? (t.preventDefault(), i(e.state, e.dispatch)) : !1 } } } }) } var So = (n, e) => { const t = Mt.getState(n); return !t || t.done.eventCount == 0 ? !1 : (e && mc(t, n, e, !1), !0) }; var xo = (n, e) => { const t = Mt.getState(n); return !t || t.undone.eventCount == 0 ? !1 : (e && mc(t, n, e, !0), !0) }; const yc = H.create({ name: 'history', addOptions() { return { depth: 100, newGroupDelay: 500 } }, addCommands() { return { undo: () => ({ state: n, dispatch: e }) => So(n, e), redo: () => ({ state: n, dispatch: e }) => xo(n, e) } }, addProseMirrorPlugins() { return [gc(this.options)] }, addKeyboardShortcuts() { return { 'Mod-z': () => this.editor.commands.undo(), 'Mod-y': () => this.editor.commands.redo(), 'Shift-Mod-z': () => this.editor.commands.redo(), 'Mod-\u044F': () => this.editor.commands.undo(), 'Shift-Mod-\u044F': () => this.editor.commands.redo() } } }); const Dc = R.create({
  name: 'horizontalRule',
  addOptions() { return { HTMLAttributes: {} } },
  group: 'block',
  parseHTML() { return [{ tag: 'hr' }] },
  renderHTML({ HTMLAttributes: n }) { return ['hr', v(this.options.HTMLAttributes, n)] },
  addCommands() {
    return {
      setHorizontalRule: () => ({ chain: n }) => n().insertContent({ type: this.name }).command(({ tr: e, dispatch: t }) => {
        let r; if (t) {
          const { $to: i } = e.selection; const s = i.end(); if (i.nodeAfter) { e.setSelection(E.create(e.doc, i.pos)) }
          else { const o = (r = i.parent.type.contentMatch.defaultType) === null || r === void 0 ? void 0 : r.create(); o && (e.insert(s, o), e.setSelection(E.create(e.doc, s))) }e.scrollIntoView()
        } return !0
      }).run(),
    }
  },
  addInputRules() { return [hu({ find: /^(?:---|—-|___\s|\*\*\*\s)$/, type: this.type })] },
}); const Hm = /(?:^|\s)((?:\*)((?:[^*]+))(?:\*))$/; const $m = /(?:^|\s)((?:\*)((?:[^*]+))(?:\*))/g; const Km = /(?:^|\s)((?:_)((?:[^_]+))(?:_))$/; const jm = /(?:^|\s)((?:_)((?:[^_]+))(?:_))/g; const bc = ie.create({ name: 'italic', addOptions() { return { HTMLAttributes: {} } }, parseHTML() { return [{ tag: 'em' }, { tag: 'i', getAttrs: n => n.style.fontStyle !== 'normal' && null }, { style: 'font-style=italic' }] }, renderHTML({ HTMLAttributes: n }) { return ['em', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setItalic: () => ({ commands: n }) => n.setMark(this.name), toggleItalic: () => ({ commands: n }) => n.toggleMark(this.name), unsetItalic: () => ({ commands: n }) => n.unsetMark(this.name) } }, addKeyboardShortcuts() { return { 'Mod-i': () => this.editor.commands.toggleItalic(), 'Mod-I': () => this.editor.commands.toggleItalic() } }, addInputRules() { return [qe({ find: Hm, type: this.type }), qe({ find: Km, type: this.type })] }, addPasteRules() { return [Ne({ find: $m, type: this.type }), Ne({ find: jm, type: this.type })] } }); const Cc = R.create({ name: 'listItem', addOptions() { return { HTMLAttributes: {} } }, content: 'paragraph block*', defining: !0, parseHTML() { return [{ tag: 'li' }] }, renderHTML({ HTMLAttributes: n }) { return ['li', v(this.options.HTMLAttributes, n), 0] }, addKeyboardShortcuts() { return { 'Enter': () => this.editor.commands.splitListItem(this.name), 'Tab': () => this.editor.commands.sinkListItem(this.name), 'Shift-Tab': () => this.editor.commands.liftListItem(this.name) } } }); const Wm = /^(\d+)\.\s$/; const kc = R.create({ name: 'orderedList', addOptions() { return { itemTypeName: 'listItem', HTMLAttributes: {} } }, group: 'block list', content() { return `${this.options.itemTypeName}+` }, addAttributes() { return { start: { default: 1, parseHTML: n => n.hasAttribute('start') ? parseInt(n.getAttribute('start') || '', 10) : 1 } } }, parseHTML() { return [{ tag: 'ol' }] }, renderHTML({ HTMLAttributes: n }) { const { start: e, ...t } = n; return e === 1 ? ['ol', v(this.options.HTMLAttributes, t), 0] : ['ol', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { toggleOrderedList: () => ({ commands: n }) => n.toggleList(this.name, this.options.itemTypeName) } }, addKeyboardShortcuts() { return { 'Mod-Shift-7': () => this.editor.commands.toggleOrderedList() } }, addInputRules() { return [kn({ find: Wm, type: this.type, getAttributes: n => ({ start: +n[1] }), joinPredicate: (n, e) => e.childCount + e.attrs.start === +n[1] })] } }); const Sc = R.create({ name: 'paragraph', priority: 1e3, addOptions() { return { HTMLAttributes: {} } }, group: 'block', content: 'inline*', parseHTML() { return [{ tag: 'p' }] }, renderHTML({ HTMLAttributes: n }) { return ['p', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setParagraph: () => ({ commands: n }) => n.setNode(this.name) } }, addKeyboardShortcuts() { return { 'Mod-Alt-0': () => this.editor.commands.setParagraph() } } }); const qm = /(?:^|\s)((?:~~)((?:[^~]+))(?:~~))$/; const _m = /(?:^|\s)((?:~~)((?:[^~]+))(?:~~))/g; const xc = ie.create({ name: 'strike', addOptions() { return { HTMLAttributes: {} } }, parseHTML() { return [{ tag: 's' }, { tag: 'del' }, { tag: 'strike' }, { style: 'text-decoration', consuming: !1, getAttrs: n => n.includes('line-through') ? {} : !1 }] }, renderHTML({ HTMLAttributes: n }) { return ['s', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setStrike: () => ({ commands: n }) => n.setMark(this.name), toggleStrike: () => ({ commands: n }) => n.toggleMark(this.name), unsetStrike: () => ({ commands: n }) => n.unsetMark(this.name) } }, addKeyboardShortcuts() { return { 'Mod-Shift-x': () => this.editor.commands.toggleStrike() } }, addInputRules() { return [qe({ find: qm, type: this.type })] }, addPasteRules() { return [Ne({ find: _m, type: this.type })] } }); const Ec = R.create({ name: 'text', group: 'inline' }); var Eo = H.create({ name: 'starterKit', addExtensions() { let n, e, t, r, i, s, o, l, a, u, c, d, f, h, p, m, g, D; const S = []; return this.options.blockquote !== !1 && S.push(pu.configure((n = this.options) === null || n === void 0 ? void 0 : n.blockquote)), this.options.bold !== !1 && S.push(mu.configure((e = this.options) === null || e === void 0 ? void 0 : e.bold)), this.options.bulletList !== !1 && S.push(gu.configure((t = this.options) === null || t === void 0 ? void 0 : t.bulletList)), this.options.code !== !1 && S.push(yu.configure((r = this.options) === null || r === void 0 ? void 0 : r.code)), this.options.codeBlock !== !1 && S.push(Du.configure((i = this.options) === null || i === void 0 ? void 0 : i.codeBlock)), this.options.document !== !1 && S.push(bu.configure((s = this.options) === null || s === void 0 ? void 0 : s.document)), this.options.dropcursor !== !1 && S.push(Ou.configure((o = this.options) === null || o === void 0 ? void 0 : o.dropcursor)), this.options.gapcursor !== !1 && S.push(uc.configure((l = this.options) === null || l === void 0 ? void 0 : l.gapcursor)), this.options.hardBreak !== !1 && S.push(cc.configure((a = this.options) === null || a === void 0 ? void 0 : a.hardBreak)), this.options.heading !== !1 && S.push(dc.configure((u = this.options) === null || u === void 0 ? void 0 : u.heading)), this.options.history !== !1 && S.push(yc.configure((c = this.options) === null || c === void 0 ? void 0 : c.history)), this.options.horizontalRule !== !1 && S.push(Dc.configure((d = this.options) === null || d === void 0 ? void 0 : d.horizontalRule)), this.options.italic !== !1 && S.push(bc.configure((f = this.options) === null || f === void 0 ? void 0 : f.italic)), this.options.listItem !== !1 && S.push(Cc.configure((h = this.options) === null || h === void 0 ? void 0 : h.listItem)), this.options.orderedList !== !1 && S.push(kc.configure((p = this.options) === null || p === void 0 ? void 0 : p.orderedList)), this.options.paragraph !== !1 && S.push(Sc.configure((m = this.options) === null || m === void 0 ? void 0 : m.paragraph)), this.options.strike !== !1 && S.push(xc.configure((g = this.options) === null || g === void 0 ? void 0 : g.strike)), this.options.text !== !1 && S.push(Ec.configure((D = this.options) === null || D === void 0 ? void 0 : D.text)), S } }); const Jm = $({ find: /--$/, replace: '\u2014' }); const Um = $({ find: /\.\.\.$/, replace: '\u2026' }); const Gm = $({ find: /(?:^|[\s{[(<'"\u2018\u201C])(")$/, replace: '\u201C' }); const Ym = $({ find: /"$/, replace: '\u201D' }); const Qm = $({ find: /(?:^|[\s{[(<'"\u2018\u201C])(')$/, replace: '\u2018' }); const Xm = $({ find: /'$/, replace: '\u2019' }); const Zm = $({ find: /<-$/, replace: '\u2190' }); const eg = $({ find: /->$/, replace: '\u2192' }); const tg = $({ find: /\(c\)$/, replace: '\xA9' }); const ng = $({ find: /\(tm\)$/, replace: '\u2122' }); const rg = $({ find: /\(r\)$/, replace: '\xAE' }); const ig = $({ find: /1\/2$/, replace: '\xBD' }); const sg = $({ find: /\+\/-$/, replace: '\xB1' }); const og = $({ find: /!=$/, replace: '\u2260' }); const lg = $({ find: /<<$/, replace: '\xAB' }); const ag = $({ find: />>$/, replace: '\xBB' }); const ug = $({ find: /\d+\s?([*x])\s?\d+$/, replace: '\xD7' }); const cg = $({ find: /\^2$/, replace: '\xB2' }); const dg = $({ find: /\^3$/, replace: '\xB3' }); const fg = $({ find: /1\/4$/, replace: '\xBC' }); const hg = $({ find: /3\/4$/, replace: '\xBE' }); var Ao = H.create({ name: 'typography', addInputRules() { const n = []; return this.options.emDash !== !1 && n.push(Jm), this.options.ellipsis !== !1 && n.push(Um), this.options.openDoubleQuote !== !1 && n.push(Gm), this.options.closeDoubleQuote !== !1 && n.push(Ym), this.options.openSingleQuote !== !1 && n.push(Qm), this.options.closeSingleQuote !== !1 && n.push(Xm), this.options.leftArrow !== !1 && n.push(Zm), this.options.rightArrow !== !1 && n.push(eg), this.options.copyright !== !1 && n.push(tg), this.options.trademark !== !1 && n.push(ng), this.options.registeredTrademark !== !1 && n.push(rg), this.options.oneHalf !== !1 && n.push(ig), this.options.plusMinus !== !1 && n.push(sg), this.options.notEqual !== !1 && n.push(og), this.options.laquo !== !1 && n.push(lg), this.options.raquo !== !1 && n.push(ag), this.options.multiplication !== !1 && n.push(ug), this.options.superscriptTwo !== !1 && n.push(cg), this.options.superscriptThree !== !1 && n.push(dg), this.options.oneQuarter !== !1 && n.push(fg), this.options.threeQuarters !== !1 && n.push(hg), n } }); var Mo = H.create({
  name: 'characterCount',
  addOptions() { return { limit: null, mode: 'textSize' } },
  addStorage() { return { characters: () => 0, words: () => 0 } },
  onBeforeCreate() { this.storage.characters = (n) => { const e = (n == null ? void 0 : n.node) || this.editor.state.doc; return ((n == null ? void 0 : n.mode) || this.options.mode) === 'textSize' ? e.textBetween(0, e.content.size, void 0, ' ').length : e.nodeSize }, this.storage.words = (n) => { const e = (n == null ? void 0 : n.node) || this.editor.state.doc; return e.textBetween(0, e.content.size, ' ', ' ').split(' ').filter(i => i !== '').length } },
  addProseMirrorPlugins() {
    return [new L({
      key: new _('characterCount'),
      filterTransaction: (n, e) => {
        const t = this.options.limit; if (!n.docChanged || t === 0 || t === null || t === void 0)
          return !0; const r = this.storage.characters({ node: e.doc }); const i = this.storage.characters({ node: n.doc }); if (i <= t || r > t && i > t && i <= r)
          return !0; if (r > t && i > t && i > r || !n.getMeta('paste'))
          return !1; const o = n.selection.$head.pos; const l = i - t; const a = o - l; const u = o; return n.deleteRange(a, u), !(this.storage.characters({ node: n.doc }) > t)
      },
    })]
  },
}); function wo(n) { this.j = {}, this.jr = [], this.jd = null, this.t = n }wo.prototype = {
  accepts() { return !!this.t },
  tt(e, t) {
    if (t && t.j)
      return this.j[e] = t, t; const r = t; let i = this.j[e]; if (i)
      return r && (i.t = r), i; i = P(); const s = ti(this, e); return s ? (Object.assign(i.j, s.j), i.jr.append(s.jr), i.jr = s.jd, i.t = r || s.t) : i.t = r, this.j[e] = i, i
  },
}; var P = function () { return new wo() }; const A = function (e) { return new wo(e) }; const C = function (e, t, r) { e.j[t] || (e.j[t] = r) }; const Y = function (e, t, r) { e.jr.push([t, r]) }; var ti = function (e, t) {
  const r = e.j[t]; if (r)
    return r; for (let i = 0; i < e.jr.length; i++) {
    const s = e.jr[i][0]; const o = e.jr[i][1]; if (s.test(t))
      return o
  } return e.jd
}; const N = function (e, t, r) { for (let i = 0; i < t.length; i++)C(e, t[i], r) }; const pg = function (e, t) { for (let r = 0; r < t.length; r++) { const i = t[r][0]; const s = t[r][1]; C(e, i, s) } }; const Zt = function (e, t, r, i) {
  for (var s = 0, o = t.length, l; s < o && (l = e.j[t[s]]);)e = l, s++; if (s >= o)
    return []; for (;s < o - 1;)l = i(), C(e, t[s], l), e = l, s++; C(e, t[o - 1], r)
}; const Pe = 'DOMAIN'; const lt = 'LOCALHOST'; const Ge = 'TLD'; const ve = 'NUM'; const Fn = 'PROTOCOL'; const Fo = 'MAILTO'; const Tc = 'WS'; const vo = 'NL'; const Mn = 'OPENBRACE'; const cr = 'OPENBRACKET'; const dr = 'OPENANGLEBRACKET'; const fr = 'OPENPAREN'; const en = 'CLOSEBRACE'; const On = 'CLOSEBRACKET'; const Tn = 'CLOSEANGLEBRACKET'; const Nn = 'CLOSEPAREN'; const ni = 'AMPERSAND'; const ri = 'APOSTROPHE'; const ii = 'ASTERISK'; const wn = 'AT'; const si = 'BACKSLASH'; const oi = 'BACKTICK'; const li = 'CARET'; const hr = 'COLON'; const Bo = 'COMMA'; const ai = 'DOLLAR'; const Tt = 'DOT'; const ui = 'EQUALS'; const Io = 'EXCLAMATION'; const ci = 'HYPHEN'; const di = 'PERCENT'; const fi = 'PIPE'; const hi = 'PLUS'; const pi = 'POUND'; const mi = 'QUERY'; const Po = 'QUOTE'; const Ro = 'SEMI'; const at = 'SLASH'; const gi = 'TILDE'; const yi = 'UNDERSCORE'; const Di = 'SYM'; const mg = Object.freeze({ __proto__: null, DOMAIN: Pe, LOCALHOST: lt, TLD: Ge, NUM: ve, PROTOCOL: Fn, MAILTO: Fo, WS: Tc, NL: vo, OPENBRACE: Mn, OPENBRACKET: cr, OPENANGLEBRACKET: dr, OPENPAREN: fr, CLOSEBRACE: en, CLOSEBRACKET: On, CLOSEANGLEBRACKET: Tn, CLOSEPAREN: Nn, AMPERSAND: ni, APOSTROPHE: ri, ASTERISK: ii, AT: wn, BACKSLASH: si, BACKTICK: oi, CARET: li, COLON: hr, COMMA: Bo, DOLLAR: ai, DOT: Tt, EQUALS: ui, EXCLAMATION: Io, HYPHEN: ci, PERCENT: di, PIPE: fi, PLUS: hi, POUND: pi, QUERY: mi, QUOTE: Po, SEMI: Ro, SLASH: at, TILDE: gi, UNDERSCORE: yi, SYM: Di }); const Ac = 'aaa aarp abarth abb abbott abbvie abc able abogado abudhabi ac academy accenture accountant accountants aco actor ad adac ads adult ae aeg aero aetna af afamilycompany afl africa ag agakhan agency ai aig airbus airforce airtel akdn al alfaromeo alibaba alipay allfinanz allstate ally alsace alstom am amazon americanexpress americanfamily amex amfam amica amsterdam analytics android anquan anz ao aol apartments app apple aq aquarelle ar arab aramco archi army arpa art arte as asda asia associates at athleta attorney au auction audi audible audio auspost author auto autos avianca aw aws ax axa az azure ba baby baidu banamex bananarepublic band bank bar barcelona barclaycard barclays barefoot bargains baseball basketball bauhaus bayern bb bbc bbt bbva bcg bcn bd be beats beauty beer bentley berlin best bestbuy bet bf bg bh bharti bi bible bid bike bing bingo bio biz bj black blackfriday blockbuster blog bloomberg blue bm bms bmw bn bnpparibas bo boats boehringer bofa bom bond boo book booking bosch bostik boston bot boutique box br bradesco bridgestone broadway broker brother brussels bs bt budapest bugatti build builders business buy buzz bv bw by bz bzh ca cab cafe cal call calvinklein cam camera camp cancerresearch canon capetown capital capitalone car caravan cards care career careers cars casa case cash casino cat catering catholic cba cbn cbre cbs cc cd center ceo cern cf cfa cfd cg ch chanel channel charity chase chat cheap chintai christmas chrome church ci cipriani circle cisco citadel citi citic city cityeats ck cl claims cleaning click clinic clinique clothing cloud club clubmed cm cn co coach codes coffee college cologne com comcast commbank community company compare computer comsec condos construction consulting contact contractors cooking cookingchannel cool coop corsica country coupon coupons courses cpa cr credit creditcard creditunion cricket crown crs cruise cruises csc cu cuisinella cv cw cx cy cymru cyou cz dabur dad dance data date dating datsun day dclk dds de deal dealer deals degree delivery dell deloitte delta democrat dental dentist desi design dev dhl diamonds diet digital direct directory discount discover dish diy dj dk dm dnp do docs doctor dog domains dot download drive dtv dubai duck dunlop dupont durban dvag dvr dz earth eat ec eco edeka edu education ee eg email emerck energy engineer engineering enterprises epson equipment er ericsson erni es esq estate et etisalat eu eurovision eus events exchange expert exposed express extraspace fage fail fairwinds faith family fan fans farm farmers fashion fast fedex feedback ferrari ferrero fi fiat fidelity fido film final finance financial fire firestone firmdale fish fishing fit fitness fj fk flickr flights flir florist flowers fly fm fo foo food foodnetwork football ford forex forsale forum foundation fox fr free fresenius frl frogans frontdoor frontier ftr fujitsu fujixerox fun fund furniture futbol fyi ga gal gallery gallo gallup game games gap garden gay gb gbiz gd gdn ge gea gent genting george gf gg ggee gh gi gift gifts gives giving gl glade glass gle global globo gm gmail gmbh gmo gmx gn godaddy gold goldpoint golf goo goodyear goog google gop got gov gp gq gr grainger graphics gratis green gripe grocery group gs gt gu guardian gucci guge guide guitars guru gw gy hair hamburg hangout haus hbo hdfc hdfcbank health healthcare help helsinki here hermes hgtv hiphop hisamitsu hitachi hiv hk hkt hm hn hockey holdings holiday homedepot homegoods homes homesense honda horse hospital host hosting hot hoteles hotels hotmail house how hr hsbc ht hu hughes hyatt hyundai ibm icbc ice icu id ie ieee ifm ikano il im imamat imdb immo immobilien in inc industries infiniti info ing ink institute insurance insure int international intuit investments io ipiranga iq ir irish is ismaili ist istanbul it itau itv iveco jaguar java jcb je jeep jetzt jewelry jio jll jm jmp jnj jo jobs joburg jot joy jp jpmorgan jprs juegos juniper kaufen kddi ke kerryhotels kerrylogistics kerryproperties kfh kg kh ki kia kim kinder kindle kitchen kiwi km kn koeln komatsu kosher kp kpmg kpn kr krd kred kuokgroup kw ky kyoto kz la lacaixa lamborghini lamer lancaster lancia land landrover lanxess lasalle lat latino latrobe law lawyer lb lc lds lease leclerc lefrak legal lego lexus lgbt li lidl life lifeinsurance lifestyle lighting like lilly limited limo lincoln linde link lipsy live living lixil lk llc llp loan loans locker locus loft lol london lotte lotto love lpl lplfinancial lr ls lt ltd ltda lu lundbeck luxe luxury lv ly ma macys madrid maif maison makeup man management mango map market marketing markets marriott marshalls maserati mattel mba mc mckinsey md me med media meet melbourne meme memorial men menu merckmsd mg mh miami microsoft mil mini mint mit mitsubishi mk ml mlb mls mm mma mn mo mobi mobile moda moe moi mom monash money monster mormon mortgage moscow moto motorcycles mov movie mp mq mr ms msd mt mtn mtr mu museum mutual mv mw mx my mz na nab nagoya name nationwide natura navy nba nc ne nec net netbank netflix network neustar new news next nextdirect nexus nf nfl ng ngo nhk ni nico nike nikon ninja nissan nissay nl no nokia northwesternmutual norton now nowruz nowtv np nr nra nrw ntt nu nyc nz obi observer off office okinawa olayan olayangroup oldnavy ollo om omega one ong onl online onyourside ooo open oracle orange org organic origins osaka otsuka ott ovh pa page panasonic paris pars partners parts party passagens pay pccw pe pet pf pfizer pg ph pharmacy phd philips phone photo photography photos physio pics pictet pictures pid pin ping pink pioneer pizza pk pl place play playstation plumbing plus pm pn pnc pohl poker politie porn post pr pramerica praxi press prime pro prod productions prof progressive promo properties property protection pru prudential ps pt pub pw pwc py qa qpon quebec quest qvc racing radio raid re read realestate realtor realty recipes red redstone redumbrella rehab reise reisen reit reliance ren rent rentals repair report republican rest restaurant review reviews rexroth rich richardli ricoh ril rio rip rmit ro rocher rocks rodeo rogers room rs rsvp ru rugby ruhr run rw rwe ryukyu sa saarland safe safety sakura sale salon samsclub samsung sandvik sandvikcoromant sanofi sap sarl sas save saxo sb sbi sbs sc sca scb schaeffler schmidt scholarships school schule schwarz science scjohnson scot sd se search seat secure security seek select sener services ses seven sew sex sexy sfr sg sh shangrila sharp shaw shell shia shiksha shoes shop shopping shouji show showtime si silk sina singles site sj sk ski skin sky skype sl sling sm smart smile sn sncf so soccer social softbank software sohu solar solutions song sony soy spa space sport spot spreadbetting sr srl ss st stada staples star statebank statefarm stc stcgroup stockholm storage store stream studio study style su sucks supplies supply support surf surgery suzuki sv swatch swiftcover swiss sx sy sydney systems sz tab taipei talk taobao target tatamotors tatar tattoo tax taxi tc tci td tdk team tech technology tel temasek tennis teva tf tg th thd theater theatre tiaa tickets tienda tiffany tips tires tirol tj tjmaxx tjx tk tkmaxx tl tm tmall tn to today tokyo tools top toray toshiba total tours town toyota toys tr trade trading training travel travelchannel travelers travelersinsurance trust trv tt tube tui tunes tushu tv tvs tw tz ua ubank ubs ug uk unicom university uno uol ups us uy uz va vacations vana vanguard vc ve vegas ventures verisign versicherung vet vg vi viajes video vig viking villas vin vip virgin visa vision viva vivo vlaanderen vn vodka volkswagen volvo vote voting voto voyage vu vuelos wales walmart walter wang wanggou watch watches weather weatherchannel webcam weber website wed wedding weibo weir wf whoswho wien wiki williamhill win windows wine winners wme wolterskluwer woodside work works world wow ws wtc wtf xbox xerox xfinity xihuan xin xxx xyz yachts yahoo yamaxun yandex ye yodobashi yoga yokohama you youtube yt yun za zappos zara zero zip zm zone zuerich zw verm\xF6gensberater-ctb verm\xF6gensberatung-pwb \u03B5\u03BB \u03B5\u03C5 \u0431\u0433 \u0431\u0435\u043B \u0434\u0435\u0442\u0438 \u0435\u044E \u043A\u0430\u0442\u043E\u043B\u0438\u043A \u043A\u043E\u043C \u049B\u0430\u0437 \u043C\u043A\u0434 \u043C\u043E\u043D \u043C\u043E\u0441\u043A\u0432\u0430 \u043E\u043D\u043B\u0430\u0439\u043D \u043E\u0440\u0433 \u0440\u0443\u0441 \u0440\u0444 \u0441\u0430\u0439\u0442 \u0441\u0440\u0431 \u0443\u043A\u0440 \u10D2\u10D4 \u0570\u0561\u0575 \u05D9\u05E9\u05E8\u05D0\u05DC \u05E7\u05D5\u05DD \u0627\u0628\u0648\u0638\u0628\u064A \u0627\u062A\u0635\u0627\u0644\u0627\u062A \u0627\u0631\u0627\u0645\u0643\u0648 \u0627\u0644\u0627\u0631\u062F\u0646 \u0627\u0644\u0628\u062D\u0631\u064A\u0646 \u0627\u0644\u062C\u0632\u0627\u0626\u0631 \u0627\u0644\u0633\u0639\u0648\u062F\u064A\u0629 \u0627\u0644\u0639\u0644\u064A\u0627\u0646 \u0627\u0644\u0645\u063A\u0631\u0628 \u0627\u0645\u0627\u0631\u0627\u062A \u0627\u06CC\u0631\u0627\u0646 \u0628\u0627\u0631\u062A \u0628\u0627\u0632\u0627\u0631 \u0628\u06BE\u0627\u0631\u062A \u0628\u064A\u062A\u0643 \u067E\u0627\u06A9\u0633\u062A\u0627\u0646 \u0680\u0627\u0631\u062A \u062A\u0648\u0646\u0633 \u0633\u0648\u062F\u0627\u0646 \u0633\u0648\u0631\u064A\u0629 \u0634\u0628\u0643\u0629 \u0639\u0631\u0627\u0642 \u0639\u0631\u0628 \u0639\u0645\u0627\u0646 \u0641\u0644\u0633\u0637\u064A\u0646 \u0642\u0637\u0631 \u0643\u0627\u062B\u0648\u0644\u064A\u0643 \u0643\u0648\u0645 \u0645\u0635\u0631 \u0645\u0644\u064A\u0633\u064A\u0627 \u0645\u0648\u0631\u064A\u062A\u0627\u0646\u064A\u0627 \u0645\u0648\u0642\u0639 \u0647\u0645\u0631\u0627\u0647 \u0915\u0949\u092E \u0928\u0947\u091F \u092D\u093E\u0930\u0924 \u092D\u093E\u0930\u0924\u092E\u094D \u092D\u093E\u0930\u094B\u0924 \u0938\u0902\u0917\u0920\u0928 \u09AC\u09BE\u0982\u09B2\u09BE \u09AD\u09BE\u09B0\u09A4 \u09AD\u09BE\u09F0\u09A4 \u0A2D\u0A3E\u0A30\u0A24 \u0AAD\u0ABE\u0AB0\u0AA4 \u0B2D\u0B3E\u0B30\u0B24 \u0B87\u0BA8\u0BCD\u0BA4\u0BBF\u0BAF\u0BBE \u0B87\u0BB2\u0B99\u0BCD\u0B95\u0BC8 \u0B9A\u0BBF\u0B99\u0BCD\u0B95\u0BAA\u0BCD\u0BAA\u0BC2\u0BB0\u0BCD \u0C2D\u0C3E\u0C30\u0C24\u0C4D \u0CAD\u0CBE\u0CB0\u0CA4 \u0D2D\u0D3E\u0D30\u0D24\u0D02 \u0DBD\u0D82\u0D9A\u0DCF \u0E04\u0E2D\u0E21 \u0E44\u0E17\u0E22 \u0EA5\u0EB2\u0EA7 \uB2F7\uB137 \uB2F7\uCEF4 \uC0BC\uC131 \uD55C\uAD6D \u30A2\u30DE\u30BE\u30F3 \u30B0\u30FC\u30B0\u30EB \u30AF\u30E9\u30A6\u30C9 \u30B3\u30E0 \u30B9\u30C8\u30A2 \u30BB\u30FC\u30EB \u30D5\u30A1\u30C3\u30B7\u30E7\u30F3 \u30DD\u30A4\u30F3\u30C8 \u307F\u3093\u306A \u4E16\u754C \u4E2D\u4FE1 \u4E2D\u56FD \u4E2D\u570B \u4E2D\u6587\u7F51 \u4E9A\u9A6C\u900A \u4F01\u4E1A \u4F5B\u5C71 \u4FE1\u606F \u5065\u5EB7 \u516B\u5366 \u516C\u53F8 \u516C\u76CA \u53F0\u6E7E \u53F0\u7063 \u5546\u57CE \u5546\u5E97 \u5546\u6807 \u5609\u91CC \u5609\u91CC\u5927\u9152\u5E97 \u5728\u7EBF \u5927\u4F17\u6C7D\u8F66 \u5927\u62FF \u5929\u4E3B\u6559 \u5A31\u4E50 \u5BB6\u96FB \u5E7F\u4E1C \u5FAE\u535A \u6148\u5584 \u6211\u7231\u4F60 \u624B\u673A \u62DB\u8058 \u653F\u52A1 \u653F\u5E9C \u65B0\u52A0\u5761 \u65B0\u95FB \u65F6\u5C1A \u66F8\u7C4D \u673A\u6784 \u6DE1\u9A6C\u9521 \u6E38\u620F \u6FB3\u9580 \u70B9\u770B \u79FB\u52A8 \u7EC4\u7EC7\u673A\u6784 \u7F51\u5740 \u7F51\u5E97 \u7F51\u7AD9 \u7F51\u7EDC \u8054\u901A \u8BFA\u57FA\u4E9A \u8C37\u6B4C \u8D2D\u7269 \u901A\u8CA9 \u96C6\u56E2 \u96FB\u8A0A\u76C8\u79D1 \u98DE\u5229\u6D66 \u98DF\u54C1 \u9910\u5385 \u9999\u683C\u91CC\u62C9 \u9999\u6E2F'.split(' '); const or = /(?:[A-Za-z\xAA\xB5\xBA\xC0-\xD6\xD8-\xF6\xF8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u037F\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u052F\u0531-\u0556\u0559\u0560-\u0588\u05D0-\u05EA\u05EF-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u0860-\u086A\u0870-\u0887\u0889-\u088E\u08A0-\u08C9\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0980\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u09FC\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0AF9\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C39\u0C3D\u0C58-\u0C5A\u0C5D\u0C60\u0C61\u0C80\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D04-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D54-\u0D56\u0D5F-\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E86-\u0E8A\u0E8C-\u0EA3\u0EA5\u0EA7-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F5\u13F8-\u13FD\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u16F1-\u16F8\u1700-\u1711\u171F-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1878\u1880-\u1884\u1887-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191E\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19B0-\u19C9\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4C\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1C80-\u1C88\u1C90-\u1CBA\u1CBD-\u1CBF\u1CE9-\u1CEC\u1CEE-\u1CF3\u1CF5\u1CF6\u1CFA\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312F\u3131-\u318E\u31A0-\u31BF\u31F0-\u31FF\u3400-\u4DBF\u4E00-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA69D\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA7CA\uA7D0\uA7D1\uA7D3\uA7D5-\uA7D9\uA7F2-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA8FD\uA8FE\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uA9E0-\uA9E4\uA9E6-\uA9EF\uA9FA-\uA9FE\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA7E-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uAB30-\uAB5A\uAB5C-\uAB69\uAB70-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC]|\uD800[\uDC00-\uDC0B\uDC0D-\uDC26\uDC28-\uDC3A\uDC3C\uDC3D\uDC3F-\uDC4D\uDC50-\uDC5D\uDC80-\uDCFA\uDE80-\uDE9C\uDEA0-\uDED0\uDF00-\uDF1F\uDF2D-\uDF40\uDF42-\uDF49\uDF50-\uDF75\uDF80-\uDF9D\uDFA0-\uDFC3\uDFC8-\uDFCF]|\uD801[\uDC00-\uDC9D\uDCB0-\uDCD3\uDCD8-\uDCFB\uDD00-\uDD27\uDD30-\uDD63\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC\uDE00-\uDF36\uDF40-\uDF55\uDF60-\uDF67\uDF80-\uDF85\uDF87-\uDFB0\uDFB2-\uDFBA]|\uD802[\uDC00-\uDC05\uDC08\uDC0A-\uDC35\uDC37\uDC38\uDC3C\uDC3F-\uDC55\uDC60-\uDC76\uDC80-\uDC9E\uDCE0-\uDCF2\uDCF4\uDCF5\uDD00-\uDD15\uDD20-\uDD39\uDD80-\uDDB7\uDDBE\uDDBF\uDE00\uDE10-\uDE13\uDE15-\uDE17\uDE19-\uDE35\uDE60-\uDE7C\uDE80-\uDE9C\uDEC0-\uDEC7\uDEC9-\uDEE4\uDF00-\uDF35\uDF40-\uDF55\uDF60-\uDF72\uDF80-\uDF91]|\uD803[\uDC00-\uDC48\uDC80-\uDCB2\uDCC0-\uDCF2\uDD00-\uDD23\uDE80-\uDEA9\uDEB0\uDEB1\uDF00-\uDF1C\uDF27\uDF30-\uDF45\uDF70-\uDF81\uDFB0-\uDFC4\uDFE0-\uDFF6]|\uD804[\uDC03-\uDC37\uDC71\uDC72\uDC75\uDC83-\uDCAF\uDCD0-\uDCE8\uDD03-\uDD26\uDD44\uDD47\uDD50-\uDD72\uDD76\uDD83-\uDDB2\uDDC1-\uDDC4\uDDDA\uDDDC\uDE00-\uDE11\uDE13-\uDE2B\uDE80-\uDE86\uDE88\uDE8A-\uDE8D\uDE8F-\uDE9D\uDE9F-\uDEA8\uDEB0-\uDEDE\uDF05-\uDF0C\uDF0F\uDF10\uDF13-\uDF28\uDF2A-\uDF30\uDF32\uDF33\uDF35-\uDF39\uDF3D\uDF50\uDF5D-\uDF61]|\uD805[\uDC00-\uDC34\uDC47-\uDC4A\uDC5F-\uDC61\uDC80-\uDCAF\uDCC4\uDCC5\uDCC7\uDD80-\uDDAE\uDDD8-\uDDDB\uDE00-\uDE2F\uDE44\uDE80-\uDEAA\uDEB8\uDF00-\uDF1A\uDF40-\uDF46]|\uD806[\uDC00-\uDC2B\uDCA0-\uDCDF\uDCFF-\uDD06\uDD09\uDD0C-\uDD13\uDD15\uDD16\uDD18-\uDD2F\uDD3F\uDD41\uDDA0-\uDDA7\uDDAA-\uDDD0\uDDE1\uDDE3\uDE00\uDE0B-\uDE32\uDE3A\uDE50\uDE5C-\uDE89\uDE9D\uDEB0-\uDEF8]|\uD807[\uDC00-\uDC08\uDC0A-\uDC2E\uDC40\uDC72-\uDC8F\uDD00-\uDD06\uDD08\uDD09\uDD0B-\uDD30\uDD46\uDD60-\uDD65\uDD67\uDD68\uDD6A-\uDD89\uDD98\uDEE0-\uDEF2\uDFB0]|\uD808[\uDC00-\uDF99]|\uD809[\uDC80-\uDD43]|\uD80B[\uDF90-\uDFF0]|[\uD80C\uD81C-\uD820\uD822\uD840-\uD868\uD86A-\uD86C\uD86F-\uD872\uD874-\uD879\uD880-\uD883][\uDC00-\uDFFF]|\uD80D[\uDC00-\uDC2E]|\uD811[\uDC00-\uDE46]|\uD81A[\uDC00-\uDE38\uDE40-\uDE5E\uDE70-\uDEBE\uDED0-\uDEED\uDF00-\uDF2F\uDF40-\uDF43\uDF63-\uDF77\uDF7D-\uDF8F]|\uD81B[\uDE40-\uDE7F\uDF00-\uDF4A\uDF50\uDF93-\uDF9F\uDFE0\uDFE1\uDFE3]|\uD821[\uDC00-\uDFF7]|\uD823[\uDC00-\uDCD5\uDD00-\uDD08]|\uD82B[\uDFF0-\uDFF3\uDFF5-\uDFFB\uDFFD\uDFFE]|\uD82C[\uDC00-\uDD22\uDD50-\uDD52\uDD64-\uDD67\uDD70-\uDEFB]|\uD82F[\uDC00-\uDC6A\uDC70-\uDC7C\uDC80-\uDC88\uDC90-\uDC99]|\uD835[\uDC00-\uDC54\uDC56-\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD1E-\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD52-\uDEA5\uDEA8-\uDEC0\uDEC2-\uDEDA\uDEDC-\uDEFA\uDEFC-\uDF14\uDF16-\uDF34\uDF36-\uDF4E\uDF50-\uDF6E\uDF70-\uDF88\uDF8A-\uDFA8\uDFAA-\uDFC2\uDFC4-\uDFCB]|\uD837[\uDF00-\uDF1E]|\uD838[\uDD00-\uDD2C\uDD37-\uDD3D\uDD4E\uDE90-\uDEAD\uDEC0-\uDEEB]|\uD839[\uDFE0-\uDFE6\uDFE8-\uDFEB\uDFED\uDFEE\uDFF0-\uDFFE]|\uD83A[\uDC00-\uDCC4\uDD00-\uDD43\uDD4B]|\uD83B[\uDE00-\uDE03\uDE05-\uDE1F\uDE21\uDE22\uDE24\uDE27\uDE29-\uDE32\uDE34-\uDE37\uDE39\uDE3B\uDE42\uDE47\uDE49\uDE4B\uDE4D-\uDE4F\uDE51\uDE52\uDE54\uDE57\uDE59\uDE5B\uDE5D\uDE5F\uDE61\uDE62\uDE64\uDE67-\uDE6A\uDE6C-\uDE72\uDE74-\uDE77\uDE79-\uDE7C\uDE7E\uDE80-\uDE89\uDE8B-\uDE9B\uDEA1-\uDEA3\uDEA5-\uDEA9\uDEAB-\uDEBB]|\uD869[\uDC00-\uDEDF\uDF00-\uDFFF]|\uD86D[\uDC00-\uDF38\uDF40-\uDFFF]|\uD86E[\uDC00-\uDC1D\uDC20-\uDFFF]|\uD873[\uDC00-\uDEA1\uDEB0-\uDFFF]|\uD87A[\uDC00-\uDFE0]|\uD87E[\uDC00-\uDE1D]|\uD884[\uDC00-\uDF4A])/; const lr = /(?:[#\*0-9\xA9\xAE\u203C\u2049\u2122\u2139\u2194-\u2199\u21A9\u21AA\u231A\u231B\u2328\u23CF\u23E9-\u23F3\u23F8-\u23FA\u24C2\u25AA\u25AB\u25B6\u25C0\u25FB-\u25FE\u2600-\u2604\u260E\u2611\u2614\u2615\u2618\u261D\u2620\u2622\u2623\u2626\u262A\u262E\u262F\u2638-\u263A\u2640\u2642\u2648-\u2653\u265F\u2660\u2663\u2665\u2666\u2668\u267B\u267E\u267F\u2692-\u2697\u2699\u269B\u269C\u26A0\u26A1\u26A7\u26AA\u26AB\u26B0\u26B1\u26BD\u26BE\u26C4\u26C5\u26C8\u26CE\u26CF\u26D1\u26D3\u26D4\u26E9\u26EA\u26F0-\u26F5\u26F7-\u26FA\u26FD\u2702\u2705\u2708-\u270D\u270F\u2712\u2714\u2716\u271D\u2721\u2728\u2733\u2734\u2744\u2747\u274C\u274E\u2753-\u2755\u2757\u2763\u2764\u2795-\u2797\u27A1\u27B0\u27BF\u2934\u2935\u2B05-\u2B07\u2B1B\u2B1C\u2B50\u2B55\u3030\u303D\u3297\u3299]|\uD83C[\uDC04\uDCCF\uDD70\uDD71\uDD7E\uDD7F\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE02\uDE1A\uDE2F\uDE32-\uDE3A\uDE50\uDE51\uDF00-\uDF21\uDF24-\uDF93\uDF96\uDF97\uDF99-\uDF9B\uDF9E-\uDFF0\uDFF3-\uDFF5\uDFF7-\uDFFF]|\uD83D[\uDC00-\uDCFD\uDCFF-\uDD3D\uDD49-\uDD4E\uDD50-\uDD67\uDD6F\uDD70\uDD73-\uDD7A\uDD87\uDD8A-\uDD8D\uDD90\uDD95\uDD96\uDDA4\uDDA5\uDDA8\uDDB1\uDDB2\uDDBC\uDDC2-\uDDC4\uDDD1-\uDDD3\uDDDC-\uDDDE\uDDE1\uDDE3\uDDE8\uDDEF\uDDF3\uDDFA-\uDE4F\uDE80-\uDEC5\uDECB-\uDED2\uDED5-\uDED7\uDEDD-\uDEE5\uDEE9\uDEEB\uDEEC\uDEF0\uDEF3-\uDEFC\uDFE0-\uDFEB\uDFF0]|\uD83E[\uDD0C-\uDD3A\uDD3C-\uDD45\uDD47-\uDDFF\uDE70-\uDE74\uDE78-\uDE7C\uDE80-\uDE86\uDE90-\uDEAC\uDEB0-\uDEBA\uDEC0-\uDEC5\uDED0-\uDED9\uDEE0-\uDEE7\uDEF0-\uDEF6])/; const ar = /\uFE0F/; const ur = /\d/; const Mc = /\s/; function gg() {
  const n = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : []; const e = P(); const t = A(ve); const r = A(Pe); const i = P(); const s = A(Tc); const o = [[ur, r], [or, r], [lr, r], [ar, r]]; const l = function () { const B = A(Pe); return B.j = { '-': i }, B.jr = [].concat(o), B }; const a = function (B) { const I = l(); return I.t = B, I }; pg(e, [['\'', A(ri)], ['{', A(Mn)], ['[', A(cr)], ['<', A(dr)], ['(', A(fr)], ['}', A(en)], [']', A(On)], ['>', A(Tn)], [')', A(Nn)], ['&', A(ni)], ['*', A(ii)], ['@', A(wn)], ['`', A(oi)], ['^', A(li)], [':', A(hr)], [',', A(Bo)], ['$', A(ai)], ['.', A(Tt)], ['=', A(ui)], ['!', A(Io)], ['-', A(ci)], ['%', A(di)], ['|', A(fi)], ['+', A(hi)], ['#', A(pi)], ['?', A(mi)], ['"', A(Po)], ['/', A(at)], [';', A(Ro)], ['~', A(gi)], ['_', A(yi)], ['\\', A(si)]]), C(e, `
`, A(vo)), Y(e, Mc, s), C(s, `
`, P()), Y(s, Mc, s); for (let u = 0; u < Ac.length; u++)Zt(e, Ac[u], a(Ge), l); const c = l(); const d = l(); const f = l(); const h = l(); Zt(e, 'file', c, l), Zt(e, 'ftp', d, l), Zt(e, 'http', f, l), Zt(e, 'mailto', h, l); const p = l(); const m = A(Fn); const g = A(Fo); C(d, 's', p), C(d, ':', m), C(f, 's', p), C(f, ':', m), C(c, ':', m), C(p, ':', m), C(h, ':', g); for (var D = l(), S = 0; S < n.length; S++)Zt(e, n[S], D, l); return C(D, ':', m), Zt(e, 'localhost', a(lt), l), Y(e, ur, t), Y(e, or, r), Y(e, lr, r), Y(e, ar, r), Y(t, ur, t), Y(t, or, r), Y(t, lr, r), Y(t, ar, r), C(t, '-', i), C(r, '-', i), C(i, '-', i), Y(r, ur, r), Y(r, or, r), Y(r, lr, r), Y(r, ar, r), Y(i, ur, r), Y(i, or, r), Y(i, lr, r), Y(i, ar, r), e.jd = A(Di), e
} function yg(n, e) { for (var t = Dg(e.replace(/[A-Z]/g, (h) => { return h.toLowerCase() })), r = t.length, i = [], s = 0, o = 0; o < r;) { for (var l = n, a = null, u = 0, c = null, d = -1, f = -1; o < r && (a = ti(l, t[o]));)l = a, l.accepts() ? (d = 0, f = 0, c = l) : d >= 0 && (d += t[o].length, f++), u += t[o].length, s += t[o].length, o++; s -= d, o -= f, u -= d, i.push({ t: c.t, v: e.substr(s - u, u), s: s - u, e: s }) } return i } function Dg(n) { for (var e = [], t = n.length, r = 0; r < t;) { const i = n.charCodeAt(r); let s = void 0; const o = i < 55296 || i > 56319 || r + 1 === t || (s = n.charCodeAt(r + 1)) < 56320 || s > 57343 ? n[r] : n.slice(r, r + 2); e.push(o), r += o.length } return e } function ei(n) { return typeof Symbol == 'function' && typeof Symbol.iterator == 'symbol' ? ei = function (e) { return typeof e } : ei = function (e) { return e && typeof Symbol == 'function' && e.constructor === Symbol && e !== Symbol.prototype ? 'symbol' : typeof e }, ei(n) } const oe = { defaultProtocol: 'http', events: null, format: Oc, formatHref: Oc, nl2br: !1, tagName: 'a', target: null, rel: null, validate: !0, truncate: 0, className: null, attributes: null, ignoreTags: [] }; function bg(n) { n = n || {}, this.defaultProtocol = 'defaultProtocol' in n ? n.defaultProtocol : oe.defaultProtocol, this.events = 'events' in n ? n.events : oe.events, this.format = 'format' in n ? n.format : oe.format, this.formatHref = 'formatHref' in n ? n.formatHref : oe.formatHref, this.nl2br = 'nl2br' in n ? n.nl2br : oe.nl2br, this.tagName = 'tagName' in n ? n.tagName : oe.tagName, this.target = 'target' in n ? n.target : oe.target, this.rel = 'rel' in n ? n.rel : oe.rel, this.validate = 'validate' in n ? n.validate : oe.validate, this.truncate = 'truncate' in n ? n.truncate : oe.truncate, this.className = 'className' in n ? n.className : oe.className, this.attributes = n.attributes || oe.attributes, this.ignoreTags = []; for (let e = ('ignoreTags' in n) ? n.ignoreTags : oe.ignoreTags, t = 0; t < e.length; t++) this.ignoreTags.push(e[t].toUpperCase()) }bg.prototype = {
  resolve(e) { const t = e.toHref(this.defaultProtocol); return { formatted: this.get('format', e.toString(), e), formattedHref: this.get('formatHref', t, e), tagName: this.get('tagName', t, e), className: this.get('className', t, e), target: this.get('target', t, e), rel: this.get('rel', t, e), events: this.getObject('events', t, e), attributes: this.getObject('attributes', t, e), truncate: this.get('truncate', t, e) } },
  check(e) { return this.get('validate', e.toString(), e) },
  get(e, t, r) {
    const i = this[e]; if (!i)
      return i; let s; switch (ei(i)) { case 'function':return i(t, r.t); case 'object':return s = r.t in i ? i[r.t] : oe[e], typeof s == 'function' ? s(t, r.t) : s } return i
  },
  getObject(e, t, r) { const i = this[e]; return typeof i == 'function' ? i(t, r.t) : i },
}; function Oc(n) { return n } function Cg(n, e) { const t = arguments.length > 2 && arguments[2] !== void 0 ? arguments[2] : {}; const r = Object.create(n.prototype); for (const i in t)r[i] = t[i]; return r.constructor = e, e.prototype = r, e } function bi() {}bi.prototype = { t: 'token', isLink: !1, toString() { return this.v }, toHref() { return this.toString() }, startIndex() { return this.tk[0].s }, endIndex() { return this.tk[this.tk.length - 1].e }, toObject() { const e = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : oe.defaultProtocol; return { type: this.t, value: this.v, isLink: this.isLink, href: this.toHref(e), start: this.startIndex(), end: this.endIndex() } } }; function tn(n, e) { function t(r, i) { this.t = n, this.v = r, this.tk = i } return Cg(bi, t, e), t } const Nc = tn('email', { isLink: !0 }); const To = tn('email', { isLink: !0, toHref() { return `mailto:${this.toString()}` } }); const No = tn('text'); const wc = tn('nl'); const Ot = tn('url', { isLink: !0, toHref() { for (var e = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : oe.defaultProtocol, t = this.tk, r = !1, i = !1, s = [], o = 0; t[o].t === Fn;)r = !0, s.push(t[o].v), o++; for (;t[o].t === at;)i = !0, s.push(t[o].v), o++; for (;o < t.length; o++)s.push(t[o].v); return s = s.join(''), r || i || (s = ''.concat(e, '://').concat(s)), s }, hasProtocol() { return this.tk[0].t === Fn } }); const kg = Object.freeze({ __proto__: null, MultiToken: bi, Base: bi, createTokenClass: tn, MailtoEmail: Nc, Email: To, Text: No, Nl: wc, Url: Ot }); function Sg() { const n = P(); const e = P(); const t = P(); const r = P(); const i = P(); const s = P(); const o = P(); const l = A(Ot); const a = P(); const u = A(Ot); const c = A(Ot); const d = P(); const f = P(); const h = P(); const p = P(); const m = P(); const g = A(Ot); const D = A(Ot); const S = A(Ot); const F = A(Ot); const B = P(); const I = P(); const fe = P(); const Q = P(); const O = P(); const le = P(); const ut = A(To); const Vo = P(); const Bc = A(To); const ct = A(Nc); const pr = P(); const dt = P(); const Nt = P(); const Ho = P(); const Ic = A(wc); C(n, vo, Ic), C(n, Fn, e), C(n, Fo, t), C(e, at, r), C(r, at, i), C(n, Ge, s), C(n, Pe, s), C(n, lt, l), C(n, ve, s), C(i, Ge, c), C(i, Pe, c), C(i, ve, c), C(i, lt, c), C(s, Tt, o), C(O, Tt, le), C(o, Ge, l), C(o, Pe, s), C(o, ve, s), C(o, lt, s), C(le, Ge, ut), C(le, Pe, O), C(le, ve, O), C(le, lt, O), C(l, Tt, o), C(ut, Tt, le), C(l, hr, a), C(l, at, c), C(a, ve, u), C(u, at, c), C(ut, hr, Vo), C(Vo, ve, Bc); const ee = [ni, ii, wn, si, oi, li, ai, Pe, ui, ci, lt, ve, di, fi, hi, pi, Fn, at, Di, gi, Ge, yi]; const te = [ri, Tn, en, On, Nn, hr, Bo, Tt, Io, dr, Mn, cr, fr, mi, Po, Ro]; C(c, Mn, f), C(c, cr, h), C(c, dr, p), C(c, fr, m), C(d, Mn, f), C(d, cr, h), C(d, dr, p), C(d, fr, m), C(f, en, c), C(h, On, c), C(p, Tn, c), C(m, Nn, c), C(g, en, c), C(D, On, c), C(S, Tn, c), C(F, Nn, c), C(B, en, c), C(I, On, c), C(fe, Tn, c), C(Q, Nn, c), N(f, ee, g), N(h, ee, D), N(p, ee, S), N(m, ee, F), N(f, te, B), N(h, te, I), N(p, te, fe), N(m, te, Q), N(g, ee, g), N(D, ee, D), N(S, ee, S), N(F, ee, F), N(g, te, g), N(D, te, D), N(S, te, S), N(F, te, F), N(B, ee, g), N(I, ee, D), N(fe, ee, S), N(Q, ee, F), N(B, te, B), N(I, te, I), N(fe, te, fe), N(Q, te, Q), N(c, ee, c), N(d, ee, c), N(c, te, d), N(d, te, d), C(t, Ge, ct), C(t, Pe, ct), C(t, ve, ct), C(t, lt, ct), N(ct, ee, ct), N(ct, te, pr), N(pr, ee, ct), N(pr, te, pr); const vn = [ni, ri, ii, si, oi, li, en, ai, Pe, ui, ci, ve, Mn, di, fi, hi, pi, mi, at, Di, gi, Ge, yi]; return N(s, vn, dt), C(s, wn, Nt), N(l, vn, dt), C(l, wn, Nt), N(o, vn, dt), N(dt, vn, dt), C(dt, wn, Nt), C(dt, Tt, Ho), N(Ho, vn, dt), C(Nt, Ge, O), C(Nt, Pe, O), C(Nt, ve, O), C(Nt, lt, ut), n } function xg(n, e, t) {
  for (var r = t.length, i = 0, s = [], o = []; i < r;) {
    for (var l = n, a = null, u = null, c = 0, d = null, f = -1; i < r && !(a = ti(l, t[i].t));)o.push(t[i++]); for (;i < r && (u = a || ti(l, t[i].t));)a = null, l = u, l.accepts() ? (f = 0, d = l) : f >= 0 && f++, i++, c++; if (f < 0) { for (let h = i - c; h < i; h++)o.push(t[h]) }
    else { o.length > 0 && (s.push(Oo(No, e, o)), o = []), i -= f, c -= f; const p = d.t; const m = t.slice(i - c, i); s.push(Oo(p, e, m)) }
  } return o.length > 0 && s.push(Oo(No, e, o)), s
} function Oo(n, e, t) { const r = t[0].s; const i = t[t.length - 1].e; const s = e.substr(r, i - r); return new n(s, t) } const Eg = typeof console < 'u' && console && console.warn || function () {}; const Ee = { scanner: null, parser: null, pluginQueue: [], customProtocols: [], initialized: !1 }; function Fc(n) {
  if (Ee.initialized && Eg('linkifyjs: already initialized - will not register custom protocol "'.concat(n, '" until you manually call linkify.init(). To avoid this warning, please register all custom protocols before invoking linkify the first time.')), !/^[a-z-]+$/.test(n))
    throw new Error('linkifyjs: protocols containing characters other than a-z or - (hyphen) are not supported'); Ee.customProtocols.push(n)
} function Ag() { Ee.scanner = { start: gg(Ee.customProtocols), tokens: mg }, Ee.parser = { start: Sg(), tokens: kg }; for (let n = { createTokenClass: tn }, e = 0; e < Ee.pluginQueue.length; e++)Ee.pluginQueue[e][1]({ scanner: Ee.scanner, parser: Ee.parser, utils: n }); Ee.initialized = !0 } function vc(n) { return Ee.initialized || Ag(), xg(Ee.parser.start, n, yg(Ee.scanner.start, n)) } function Ci(n) { for (var e = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : null, t = vc(n), r = [], i = 0; i < t.length; i++) { const s = t[i]; s.isLink && (!e || s.t === e) && r.push(s.toObject()) } return r } function Lo(n) { const e = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : null; const t = vc(n); return t.length === 1 && t[0].isLink && (!e || t[0].t === e) } function Mg(n) {
  return new L({
    key: new _('autolink'),
    appendTransaction: (e, t, r) => {
      const i = e.some(c => c.docChanged) && !t.doc.eq(r.doc); const s = e.some(c => c.getMeta('preventAutolink')); if (!i || s)
        return; const { tr: o } = r; const l = cu(t.doc, [...e]); const { mapping: a } = l; if (fu(l).forEach(({ oldRange: c, newRange: d }) => {
        Gn(c.from, c.to, t.doc).filter(f => f.mark.type === n.type).forEach((f) => {
          const h = a.map(f.from); const p = a.map(f.to); const m = Gn(h, p, r.doc).filter(I => I.mark.type === n.type); if (!m.length)
            return; const g = m[0]; const D = t.doc.textBetween(f.from, f.to, void 0, ' '); const S = r.doc.textBetween(g.from, g.to, void 0, ' '); const F = Lo(D); const B = Lo(S); F && !B && o.removeMark(g.from, g.to, n.type)
        }), du(r.doc, d, f => f.isTextblock).forEach((f) => { const h = r.doc.textBetween(f.pos, f.pos + f.node.nodeSize, void 0, ' '); Ci(h).filter(p => p.isLink).filter(p => n.validate ? n.validate(p.value) : !0).map(p => ({ ...p, from: f.pos + p.start + 1, to: f.pos + p.end + 1 })).filter((p) => { const m = d.from >= p.from && d.from <= p.to; const g = d.to >= p.from && d.to <= p.to; return m || g }).forEach((p) => { o.addMark(p.from, p.to, n.type.create({ href: p.href })) }) })
      }), !!o.steps.length)
        return o
    },
  })
} function Og(n) { return new L({ key: new _('handleClickLink'), props: { handleClick: (e, t, r) => { let i; const s = Us(e.state, n.type.name); return ((i = r.target) === null || i === void 0 ? void 0 : i.closest('a')) && s.href ? (window.open(s.href, s.target), !0) : !1 } } }) } function Tg(n) {
  return new L({
    key: new _('handlePasteLink'),
    props: {
      handlePaste: (e, t, r) => {
        const { state: i } = e; const { selection: s } = i; const { empty: o } = s; if (o)
          return !1; let l = ''; r.content.forEach((u) => { l += u.textContent }); const a = Ci(l).find(u => u.isLink && u.value === l); return !l || !a ? !1 : (n.editor.commands.setMark(n.type, { href: a.href }), !0)
      },
    },
  })
} var zo = ie.create({ name: 'link', priority: 1e3, keepOnSplit: !1, onCreate() { this.options.protocols.forEach(Fc) }, inclusive() { return this.options.autolink }, addOptions() { return { openOnClick: !0, linkOnPaste: !0, autolink: !0, protocols: [], HTMLAttributes: { target: '_blank', rel: 'noopener noreferrer nofollow', class: null }, validate: void 0 } }, addAttributes() { return { href: { default: null }, target: { default: this.options.HTMLAttributes.target }, class: { default: this.options.HTMLAttributes.class } } }, parseHTML() { return [{ tag: 'a[href]:not([href *= "javascript:" i])' }] }, renderHTML({ HTMLAttributes: n }) { return ['a', v(this.options.HTMLAttributes, n), 0] }, addCommands() { return { setLink: n => ({ chain: e }) => e().setMark(this.name, n).setMeta('preventAutolink', !0).run(), toggleLink: n => ({ chain: e }) => e().toggleMark(this.name, n, { extendEmptyMarkRange: !0 }).setMeta('preventAutolink', !0).run(), unsetLink: () => ({ chain: n }) => n().unsetMark(this.name, { extendEmptyMarkRange: !0 }).setMeta('preventAutolink', !0).run() } }, addPasteRules() { return [Ne({ find: n => Ci(n).filter(e => this.options.validate ? this.options.validate(e.value) : !0).filter(e => e.isLink).map(e => ({ text: e.value, index: e.start, data: e })), type: this.type, getAttributes: (n) => { let e; return { href: (e = n.data) === null || e === void 0 ? void 0 : e.href } } })] }, addProseMirrorPlugins() { const n = []; return this.options.autolink && n.push(Mg({ type: this.type, validate: this.options.validate })), this.options.openOnClick && n.push(Og({ type: this.type })), this.options.linkOnPaste && n.push(Tg({ editor: this.editor, type: this.type })), n } }); 0 && (module.exports = { CharacterCount, Editor, Link, StarterKit, Typography })
