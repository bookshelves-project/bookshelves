const e = 0; const t = 1; const n = -2; const i = -3; const r = -4; const a = -5; const s = [0, 1, 3, 7, 15, 31, 63, 127, 255, 511, 1023, 2047, 4095, 8191, 16383, 32767, 65535]; const o = 1440; const l = [96, 7, 256, 0, 8, 80, 0, 8, 16, 84, 8, 115, 82, 7, 31, 0, 8, 112, 0, 8, 48, 0, 9, 192, 80, 7, 10, 0, 8, 96, 0, 8, 32, 0, 9, 160, 0, 8, 0, 0, 8, 128, 0, 8, 64, 0, 9, 224, 80, 7, 6, 0, 8, 88, 0, 8, 24, 0, 9, 144, 83, 7, 59, 0, 8, 120, 0, 8, 56, 0, 9, 208, 81, 7, 17, 0, 8, 104, 0, 8, 40, 0, 9, 176, 0, 8, 8, 0, 8, 136, 0, 8, 72, 0, 9, 240, 80, 7, 4, 0, 8, 84, 0, 8, 20, 85, 8, 227, 83, 7, 43, 0, 8, 116, 0, 8, 52, 0, 9, 200, 81, 7, 13, 0, 8, 100, 0, 8, 36, 0, 9, 168, 0, 8, 4, 0, 8, 132, 0, 8, 68, 0, 9, 232, 80, 7, 8, 0, 8, 92, 0, 8, 28, 0, 9, 152, 84, 7, 83, 0, 8, 124, 0, 8, 60, 0, 9, 216, 82, 7, 23, 0, 8, 108, 0, 8, 44, 0, 9, 184, 0, 8, 12, 0, 8, 140, 0, 8, 76, 0, 9, 248, 80, 7, 3, 0, 8, 82, 0, 8, 18, 85, 8, 163, 83, 7, 35, 0, 8, 114, 0, 8, 50, 0, 9, 196, 81, 7, 11, 0, 8, 98, 0, 8, 34, 0, 9, 164, 0, 8, 2, 0, 8, 130, 0, 8, 66, 0, 9, 228, 80, 7, 7, 0, 8, 90, 0, 8, 26, 0, 9, 148, 84, 7, 67, 0, 8, 122, 0, 8, 58, 0, 9, 212, 82, 7, 19, 0, 8, 106, 0, 8, 42, 0, 9, 180, 0, 8, 10, 0, 8, 138, 0, 8, 74, 0, 9, 244, 80, 7, 5, 0, 8, 86, 0, 8, 22, 192, 8, 0, 83, 7, 51, 0, 8, 118, 0, 8, 54, 0, 9, 204, 81, 7, 15, 0, 8, 102, 0, 8, 38, 0, 9, 172, 0, 8, 6, 0, 8, 134, 0, 8, 70, 0, 9, 236, 80, 7, 9, 0, 8, 94, 0, 8, 30, 0, 9, 156, 84, 7, 99, 0, 8, 126, 0, 8, 62, 0, 9, 220, 82, 7, 27, 0, 8, 110, 0, 8, 46, 0, 9, 188, 0, 8, 14, 0, 8, 142, 0, 8, 78, 0, 9, 252, 96, 7, 256, 0, 8, 81, 0, 8, 17, 85, 8, 131, 82, 7, 31, 0, 8, 113, 0, 8, 49, 0, 9, 194, 80, 7, 10, 0, 8, 97, 0, 8, 33, 0, 9, 162, 0, 8, 1, 0, 8, 129, 0, 8, 65, 0, 9, 226, 80, 7, 6, 0, 8, 89, 0, 8, 25, 0, 9, 146, 83, 7, 59, 0, 8, 121, 0, 8, 57, 0, 9, 210, 81, 7, 17, 0, 8, 105, 0, 8, 41, 0, 9, 178, 0, 8, 9, 0, 8, 137, 0, 8, 73, 0, 9, 242, 80, 7, 4, 0, 8, 85, 0, 8, 21, 80, 8, 258, 83, 7, 43, 0, 8, 117, 0, 8, 53, 0, 9, 202, 81, 7, 13, 0, 8, 101, 0, 8, 37, 0, 9, 170, 0, 8, 5, 0, 8, 133, 0, 8, 69, 0, 9, 234, 80, 7, 8, 0, 8, 93, 0, 8, 29, 0, 9, 154, 84, 7, 83, 0, 8, 125, 0, 8, 61, 0, 9, 218, 82, 7, 23, 0, 8, 109, 0, 8, 45, 0, 9, 186, 0, 8, 13, 0, 8, 141, 0, 8, 77, 0, 9, 250, 80, 7, 3, 0, 8, 83, 0, 8, 19, 85, 8, 195, 83, 7, 35, 0, 8, 115, 0, 8, 51, 0, 9, 198, 81, 7, 11, 0, 8, 99, 0, 8, 35, 0, 9, 166, 0, 8, 3, 0, 8, 131, 0, 8, 67, 0, 9, 230, 80, 7, 7, 0, 8, 91, 0, 8, 27, 0, 9, 150, 84, 7, 67, 0, 8, 123, 0, 8, 59, 0, 9, 214, 82, 7, 19, 0, 8, 107, 0, 8, 43, 0, 9, 182, 0, 8, 11, 0, 8, 139, 0, 8, 75, 0, 9, 246, 80, 7, 5, 0, 8, 87, 0, 8, 23, 192, 8, 0, 83, 7, 51, 0, 8, 119, 0, 8, 55, 0, 9, 206, 81, 7, 15, 0, 8, 103, 0, 8, 39, 0, 9, 174, 0, 8, 7, 0, 8, 135, 0, 8, 71, 0, 9, 238, 80, 7, 9, 0, 8, 95, 0, 8, 31, 0, 9, 158, 84, 7, 99, 0, 8, 127, 0, 8, 63, 0, 9, 222, 82, 7, 27, 0, 8, 111, 0, 8, 47, 0, 9, 190, 0, 8, 15, 0, 8, 143, 0, 8, 79, 0, 9, 254, 96, 7, 256, 0, 8, 80, 0, 8, 16, 84, 8, 115, 82, 7, 31, 0, 8, 112, 0, 8, 48, 0, 9, 193, 80, 7, 10, 0, 8, 96, 0, 8, 32, 0, 9, 161, 0, 8, 0, 0, 8, 128, 0, 8, 64, 0, 9, 225, 80, 7, 6, 0, 8, 88, 0, 8, 24, 0, 9, 145, 83, 7, 59, 0, 8, 120, 0, 8, 56, 0, 9, 209, 81, 7, 17, 0, 8, 104, 0, 8, 40, 0, 9, 177, 0, 8, 8, 0, 8, 136, 0, 8, 72, 0, 9, 241, 80, 7, 4, 0, 8, 84, 0, 8, 20, 85, 8, 227, 83, 7, 43, 0, 8, 116, 0, 8, 52, 0, 9, 201, 81, 7, 13, 0, 8, 100, 0, 8, 36, 0, 9, 169, 0, 8, 4, 0, 8, 132, 0, 8, 68, 0, 9, 233, 80, 7, 8, 0, 8, 92, 0, 8, 28, 0, 9, 153, 84, 7, 83, 0, 8, 124, 0, 8, 60, 0, 9, 217, 82, 7, 23, 0, 8, 108, 0, 8, 44, 0, 9, 185, 0, 8, 12, 0, 8, 140, 0, 8, 76, 0, 9, 249, 80, 7, 3, 0, 8, 82, 0, 8, 18, 85, 8, 163, 83, 7, 35, 0, 8, 114, 0, 8, 50, 0, 9, 197, 81, 7, 11, 0, 8, 98, 0, 8, 34, 0, 9, 165, 0, 8, 2, 0, 8, 130, 0, 8, 66, 0, 9, 229, 80, 7, 7, 0, 8, 90, 0, 8, 26, 0, 9, 149, 84, 7, 67, 0, 8, 122, 0, 8, 58, 0, 9, 213, 82, 7, 19, 0, 8, 106, 0, 8, 42, 0, 9, 181, 0, 8, 10, 0, 8, 138, 0, 8, 74, 0, 9, 245, 80, 7, 5, 0, 8, 86, 0, 8, 22, 192, 8, 0, 83, 7, 51, 0, 8, 118, 0, 8, 54, 0, 9, 205, 81, 7, 15, 0, 8, 102, 0, 8, 38, 0, 9, 173, 0, 8, 6, 0, 8, 134, 0, 8, 70, 0, 9, 237, 80, 7, 9, 0, 8, 94, 0, 8, 30, 0, 9, 157, 84, 7, 99, 0, 8, 126, 0, 8, 62, 0, 9, 221, 82, 7, 27, 0, 8, 110, 0, 8, 46, 0, 9, 189, 0, 8, 14, 0, 8, 142, 0, 8, 78, 0, 9, 253, 96, 7, 256, 0, 8, 81, 0, 8, 17, 85, 8, 131, 82, 7, 31, 0, 8, 113, 0, 8, 49, 0, 9, 195, 80, 7, 10, 0, 8, 97, 0, 8, 33, 0, 9, 163, 0, 8, 1, 0, 8, 129, 0, 8, 65, 0, 9, 227, 80, 7, 6, 0, 8, 89, 0, 8, 25, 0, 9, 147, 83, 7, 59, 0, 8, 121, 0, 8, 57, 0, 9, 211, 81, 7, 17, 0, 8, 105, 0, 8, 41, 0, 9, 179, 0, 8, 9, 0, 8, 137, 0, 8, 73, 0, 9, 243, 80, 7, 4, 0, 8, 85, 0, 8, 21, 80, 8, 258, 83, 7, 43, 0, 8, 117, 0, 8, 53, 0, 9, 203, 81, 7, 13, 0, 8, 101, 0, 8, 37, 0, 9, 171, 0, 8, 5, 0, 8, 133, 0, 8, 69, 0, 9, 235, 80, 7, 8, 0, 8, 93, 0, 8, 29, 0, 9, 155, 84, 7, 83, 0, 8, 125, 0, 8, 61, 0, 9, 219, 82, 7, 23, 0, 8, 109, 0, 8, 45, 0, 9, 187, 0, 8, 13, 0, 8, 141, 0, 8, 77, 0, 9, 251, 80, 7, 3, 0, 8, 83, 0, 8, 19, 85, 8, 195, 83, 7, 35, 0, 8, 115, 0, 8, 51, 0, 9, 199, 81, 7, 11, 0, 8, 99, 0, 8, 35, 0, 9, 167, 0, 8, 3, 0, 8, 131, 0, 8, 67, 0, 9, 231, 80, 7, 7, 0, 8, 91, 0, 8, 27, 0, 9, 151, 84, 7, 67, 0, 8, 123, 0, 8, 59, 0, 9, 215, 82, 7, 19, 0, 8, 107, 0, 8, 43, 0, 9, 183, 0, 8, 11, 0, 8, 139, 0, 8, 75, 0, 9, 247, 80, 7, 5, 0, 8, 87, 0, 8, 23, 192, 8, 0, 83, 7, 51, 0, 8, 119, 0, 8, 55, 0, 9, 207, 81, 7, 15, 0, 8, 103, 0, 8, 39, 0, 9, 175, 0, 8, 7, 0, 8, 135, 0, 8, 71, 0, 9, 239, 80, 7, 9, 0, 8, 95, 0, 8, 31, 0, 9, 159, 84, 7, 99, 0, 8, 127, 0, 8, 63, 0, 9, 223, 82, 7, 27, 0, 8, 111, 0, 8, 47, 0, 9, 191, 0, 8, 15, 0, 8, 143, 0, 8, 79, 0, 9, 255]; const c = [80, 5, 1, 87, 5, 257, 83, 5, 17, 91, 5, 4097, 81, 5, 5, 89, 5, 1025, 85, 5, 65, 93, 5, 16385, 80, 5, 3, 88, 5, 513, 84, 5, 33, 92, 5, 8193, 82, 5, 9, 90, 5, 2049, 86, 5, 129, 192, 5, 24577, 80, 5, 2, 87, 5, 385, 83, 5, 25, 91, 5, 6145, 81, 5, 7, 89, 5, 1537, 85, 5, 97, 93, 5, 24577, 80, 5, 4, 88, 5, 769, 84, 5, 49, 92, 5, 12289, 82, 5, 13, 90, 5, 3073, 86, 5, 193, 192, 5, 24577]; const u = [3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 19, 23, 27, 31, 35, 43, 51, 59, 67, 83, 99, 115, 131, 163, 195, 227, 258, 0, 0]; const d = [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 0, 112, 112]; const f = [1, 2, 3, 4, 5, 7, 9, 13, 17, 25, 33, 49, 65, 97, 129, 193, 257, 385, 513, 769, 1025, 1537, 2049, 3073, 4097, 6145, 8193, 12289, 16385, 24577]; const h = [0, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13]; const _ = 15; function w() {
  let t, n, s, l, c, w; function b(t, n, r, u, d, f, h, b, p, m, g) {
    let y, x, k, v, S, z, A, U, D, E, F, O, T, W, C; E = 0, S = r; do { s[t[n + E]]++, E++, S-- } while (S !== 0); if (s[0] == r)
      return h[0] = -1, b[0] = 0, e; for (U = b[0], z = 1; z <= _ && s[z] === 0; z++);for (A = z, U < z && (U = z), S = _; S !== 0 && s[S] === 0; S--);for (k = S, U > S && (U = S), b[0] = U, W = 1 << z; z < S; z++, W <<= 1) {
      if ((W -= s[z]) < 0)
        return i
    } if ((W -= s[S]) < 0)
      return i; for (s[S] += W, w[1] = z = 0, E = 1, T = 2; --S != 0;)w[T] = z += s[E], T++, E++; S = 0, E = 0; do { (z = t[n + E]) !== 0 && (g[w[z]++] = S), E++ } while (++S < r); for (r = w[k], w[0] = S = 0, E = 0, v = -1, O = -U, c[0] = 0, F = 0, C = 0; A <= k; A++) {
      for (y = s[A]; y-- != 0;) {
        for (;A > O + U;) {
          if (v++, O += U, C = k - O, C = C > U ? U : C, (x = 1 << (z = A - O)) > y + 1 && (x -= y + 1, T = A, z < C)) {
            for (;++z < C && !((x <<= 1) <= s[++T]);)x -= s[T]
          } if (C = 1 << z, m[0] + C > o)
            return i; c[v] = F = m[0], m[0] += C, v !== 0 ? (w[v] = S, l[0] = z, l[1] = U, z = S >>> O - U, l[2] = F - c[v - 1] - z, p.set(l, 3 * (c[v - 1] + z))) : h[0] = F
        } for (l[1] = A - O, E >= r ? l[0] = 192 : g[E] < u ? (l[0] = g[E] < 256 ? 0 : 96, l[2] = g[E++]) : (l[0] = f[g[E] - u] + 16 + 64, l[2] = d[g[E++] - u]), x = 1 << A - O, z = S >>> O; z < C; z += x)p.set(l, 3 * (F + z)); for (z = 1 << A - 1; (S & z) != 0; z >>>= 1)S ^= z; for (S ^= z, D = (1 << O) - 1; (S & D) != w[v];)v--, O -= U, D = (1 << O) - 1
      }
    } return W !== 0 && k != 1 ? a : e
  } function p(e) { let i; for (t || (t = [], n = [], s = new Int32Array(_ + 1), l = [], c = new Int32Array(_), w = new Int32Array(_ + 1)), n.length < e && (n = []), i = 0; i < e; i++)n[i] = 0; for (i = 0; i < _ + 1; i++)s[i] = 0; for (i = 0; i < 3; i++)l[i] = 0; c.set(s.subarray(0, _), 0), w.set(s.subarray(0, _ + 1), 0) } this.inflate_trees_bits = function (e, r, s, o, l) { let c; return p(19), t[0] = 0, c = b(e, 0, 19, 19, null, null, s, r, o, t, n), c == i ? l.msg = 'oversubscribed dynamic bit lengths tree' : c != a && r[0] !== 0 || (l.msg = 'incomplete dynamic bit lengths tree', c = i), c }, this.inflate_trees_dynamic = function (s, o, l, c, _, w, m, g, y) { let x; return p(288), t[0] = 0, x = b(l, 0, s, 257, u, d, w, c, g, t, n), x != e || c[0] === 0 ? (x == i ? y.msg = 'oversubscribed literal/length tree' : x != r && (y.msg = 'incomplete literal/length tree', x = i), x) : (p(288), x = b(l, s, o, 0, f, h, m, _, g, t, n), x != e || _[0] === 0 && s > 257 ? (x == i ? y.msg = 'oversubscribed distance tree' : x == a ? (y.msg = 'incomplete distance tree', x = i) : x != r && (y.msg = 'empty distance tree with lengths', x = i), x) : e) }
}w.inflate_trees_fixed = function (t, n, i, r) { return t[0] = 9, n[0] = 5, i[0] = l, r[0] = c, e }; const b = 0; const p = 1; const m = 2; const g = 3; const y = 4; const x = 5; const k = 6; const v = 7; const S = 8; const z = 9; function A() {
  const r = this; let a; let o; let l; let c; let u = 0; let d = 0; let f = 0; let h = 0; let _ = 0; let w = 0; let A = 0; let U = 0; let D = 0; let E = 0; function F(n, r, a, o, l, c, u, d) {
    let f, h, _, w, b, p, m, g, y, x, k, v, S, z, A, U; m = d.next_in_index, g = d.avail_in, b = u.bitb, p = u.bitk, y = u.write, x = y < u.read ? u.read - y - 1 : u.end - y, k = s[n], v = s[r]; do {
      for (;p < 20;)g--, b |= (255 & d.read_byte(m++)) << p, p += 8; if (f = b & k, h = a, _ = o, U = 3 * (_ + f), (w = h[U]) !== 0) {
        for (;;) {
          if (b >>= h[U + 1], p -= h[U + 1], (16 & w) != 0) {
            for (w &= 15, S = h[U + 2] + (b & s[w]), b >>= w, p -= w; p < 15;)g--, b |= (255 & d.read_byte(m++)) << p, p += 8; for (f = b & v, h = l, _ = c, U = 3 * (_ + f), w = h[U]; ;) {
              if (b >>= h[U + 1], p -= h[U + 1], (16 & w) != 0) {
                for (w &= 15; p < w;)g--, b |= (255 & d.read_byte(m++)) << p, p += 8; if (z = h[U + 2] + (b & s[w]), b >>= w, p -= w, x -= S, y >= z) {
                  A = y - z, y - A > 0 && y - A < 2 ? (u.win[y++] = u.win[A++], u.win[y++] = u.win[A++], S -= 2) : (u.win.set(u.win.subarray(A, A + 2), y), y += 2, A += 2, S -= 2)
                }
                else {
                  A = y - z; do { A += u.end } while (A < 0); if (w = u.end - A, S > w) {
                    if (S -= w, y - A > 0 && w > y - A) {
                      do { u.win[y++] = u.win[A++] } while (--w != 0)
                    }
                    else {
                      u.win.set(u.win.subarray(A, A + w), y), y += w, A += w, w = 0
                    }A = 0
                  }
                } if (y - A > 0 && S > y - A) {
                  do { u.win[y++] = u.win[A++] } while (--S != 0)
                }
                else {
                  u.win.set(u.win.subarray(A, A + S), y), y += S, A += S, S = 0
                } break
              } if ((64 & w) != 0)
                return d.msg = 'invalid distance code', S = d.avail_in - g, S = p >> 3 < S ? p >> 3 : S, g += S, m -= S, p -= S << 3, u.bitb = b, u.bitk = p, d.avail_in = g, d.total_in += m - d.next_in_index, d.next_in_index = m, u.write = y, i; f += h[U + 2], f += b & s[w], U = 3 * (_ + f), w = h[U]
            } break
          } if ((64 & w) != 0)
            return (32 & w) != 0 ? (S = d.avail_in - g, S = p >> 3 < S ? p >> 3 : S, g += S, m -= S, p -= S << 3, u.bitb = b, u.bitk = p, d.avail_in = g, d.total_in += m - d.next_in_index, d.next_in_index = m, u.write = y, t) : (d.msg = 'invalid literal/length code', S = d.avail_in - g, S = p >> 3 < S ? p >> 3 : S, g += S, m -= S, p -= S << 3, u.bitb = b, u.bitk = p, d.avail_in = g, d.total_in += m - d.next_in_index, d.next_in_index = m, u.write = y, i); if (f += h[U + 2], f += b & s[w], U = 3 * (_ + f), (w = h[U]) === 0) { b >>= h[U + 1], p -= h[U + 1], u.win[y++] = h[U + 2], x--; break }
        }
      }
      else {
        b >>= h[U + 1], p -= h[U + 1], u.win[y++] = h[U + 2], x--
      }
    } while (x >= 258 && g >= 10); return S = d.avail_in - g, S = p >> 3 < S ? p >> 3 : S, g += S, m -= S, p -= S << 3, u.bitb = b, u.bitk = p, d.avail_in = g, d.total_in += m - d.next_in_index, d.next_in_index = m, u.write = y, e
  }r.init = function (e, t, n, i, r, s) { a = b, A = e, U = t, l = n, D = i, c = r, E = s, o = null }, r.proc = function (r, O, T) {
    let W; let C; let j; let M; let L; let P; let R; let B = 0; let I = 0; let N = 0; for (N = O.next_in_index, M = O.avail_in, B = r.bitb, I = r.bitk, L = r.write, P = L < r.read ? r.read - L - 1 : r.end - L; ;) {
      switch (a) {
        case b:if (P >= 258 && M >= 10 && (r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, T = F(A, U, l, D, c, E, r, O), N = O.next_in_index, M = O.avail_in, B = r.bitb, I = r.bitk, L = r.write, P = L < r.read ? r.read - L - 1 : r.end - L, T != e)) { a = T == t ? v : z; break }f = A, o = l, d = D, a = p; case p:for (W = f; I < W;) {
          if (M === 0)
            return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); T = e, M--, B |= (255 & O.read_byte(N++)) << I, I += 8
        } if (C = 3 * (d + (B & s[W])), B >>>= o[C + 1], I -= o[C + 1], j = o[C], j === 0) { h = o[C + 2], a = k; break } if ((16 & j) != 0) { _ = 15 & j, u = o[C + 2], a = m; break } if ((64 & j) == 0) { f = j, d = C / 3 + o[C + 2]; break } if ((32 & j) != 0) { a = v; break } return a = z, O.msg = 'invalid literal/length code', T = i, r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); case m:for (W = _; I < W;) {
          if (M === 0)
            return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); T = e, M--, B |= (255 & O.read_byte(N++)) << I, I += 8
        }u += B & s[W], B >>= W, I -= W, f = U, o = c, d = E, a = g; case g:for (W = f; I < W;) {
          if (M === 0)
            return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); T = e, M--, B |= (255 & O.read_byte(N++)) << I, I += 8
        } if (C = 3 * (d + (B & s[W])), B >>= o[C + 1], I -= o[C + 1], j = o[C], (16 & j) != 0) { _ = 15 & j, w = o[C + 2], a = y; break } if ((64 & j) == 0) { f = j, d = C / 3 + o[C + 2]; break } return a = z, O.msg = 'invalid distance code', T = i, r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); case y:for (W = _; I < W;) {
          if (M === 0)
            return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); T = e, M--, B |= (255 & O.read_byte(N++)) << I, I += 8
        }w += B & s[W], B >>= W, I -= W, a = x; case x:for (R = L - w; R < 0;)R += r.end; for (;u !== 0;) {
          if (P === 0 && (L == r.end && r.read !== 0 && (L = 0, P = L < r.read ? r.read - L - 1 : r.end - L), P === 0 && (r.write = L, T = r.inflate_flush(O, T), L = r.write, P = L < r.read ? r.read - L - 1 : r.end - L, L == r.end && r.read !== 0 && (L = 0, P = L < r.read ? r.read - L - 1 : r.end - L), P === 0)))
            return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); r.win[L++] = r.win[R++], P--, R == r.end && (R = 0), u--
        }a = b; break; case k:if (P === 0 && (L == r.end && r.read !== 0 && (L = 0, P = L < r.read ? r.read - L - 1 : r.end - L), P === 0 && (r.write = L, T = r.inflate_flush(O, T), L = r.write, P = L < r.read ? r.read - L - 1 : r.end - L, L == r.end && r.read !== 0 && (L = 0, P = L < r.read ? r.read - L - 1 : r.end - L), P === 0)))
          return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); T = e, r.win[L++] = h, P--, a = b; break; case v:if (I > 7 && (I -= 8, M++, N--), r.write = L, T = r.inflate_flush(O, T), L = r.write, P = L < r.read ? r.read - L - 1 : r.end - L, r.read != r.write)
          return r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); a = S; case S:return T = t, r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); case z:return T = i, r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T); default:return T = n, r.bitb = B, r.bitk = I, O.avail_in = M, O.total_in += N - O.next_in_index, O.next_in_index = N, r.write = L, r.inflate_flush(O, T)
      }
    }
  }, r.free = function () {}
} const U = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15]; const D = 0; const E = 1; const F = 2; const O = 3; const T = 4; const W = 5; const C = 6; const j = 7; const M = 8; const L = 9; function P(r, l) {
  const c = this; let u; let d = D; let f = 0; let h = 0; let _ = 0; const b = [0]; const p = [0]; const m = new A(); let g = 0; let y = new Int32Array(3 * o); const x = new w(); c.bitk = 0, c.bitb = 0, c.win = new Uint8Array(l), c.end = l, c.read = 0, c.write = 0, c.reset = function (e, t) { t && (t[0] = 0), d == C && m.free(e), d = D, c.bitk = 0, c.bitb = 0, c.read = c.write = 0 }, c.reset(r, null), c.inflate_flush = function (t, n) { let i, r, s; return r = t.next_out_index, s = c.read, i = (s <= c.write ? c.write : c.end) - s, i > t.avail_out && (i = t.avail_out), i !== 0 && n == a && (n = e), t.avail_out -= i, t.total_out += i, t.next_out.set(c.win.subarray(s, s + i), r), r += i, s += i, s == c.end && (s = 0, c.write == c.end && (c.write = 0), i = c.write - s, i > t.avail_out && (i = t.avail_out), i !== 0 && n == a && (n = e), t.avail_out -= i, t.total_out += i, t.next_out.set(c.win.subarray(s, s + i), r), r += i, s += i), t.next_out_index = r, c.read = s, n }, c.proc = function (r, a) {
    let o, l, k, v, S, z, A, P; for (v = r.next_in_index, S = r.avail_in, l = c.bitb, k = c.bitk, z = c.write, A = z < c.read ? c.read - z - 1 : c.end - z; ;) {
      let R, B, I, N, V, q, H, K; switch (d) {
        case D:for (;k < 3;) {
          if (S === 0)
            return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); a = e, S--, l |= (255 & r.read_byte(v++)) << k, k += 8
        } switch (o = 7 & l, g = 1 & o, o >>> 1) { case 0:l >>>= 3, k -= 3, o = 7 & k, l >>>= o, k -= o, d = E; break; case 1:R = [], B = [], I = [[]], N = [[]], w.inflate_trees_fixed(R, B, I, N), m.init(R[0], B[0], I[0], 0, N[0], 0), l >>>= 3, k -= 3, d = C; break; case 2:l >>>= 3, k -= 3, d = O; break; case 3:return l >>>= 3, k -= 3, d = L, r.msg = 'invalid block type', a = i, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a) } break; case E:for (;k < 32;) {
          if (S === 0)
            return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); a = e, S--, l |= (255 & r.read_byte(v++)) << k, k += 8
        } if ((~l >>> 16 & 65535) != (65535 & l))
            return d = L, r.msg = 'invalid stored block lengths', a = i, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); f = 65535 & l, l = k = 0, d = f !== 0 ? F : g !== 0 ? j : D; break; case F:if (S === 0)
          return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); if (A === 0 && (z == c.end && c.read !== 0 && (z = 0, A = z < c.read ? c.read - z - 1 : c.end - z), A === 0 && (c.write = z, a = c.inflate_flush(r, a), z = c.write, A = z < c.read ? c.read - z - 1 : c.end - z, z == c.end && c.read !== 0 && (z = 0, A = z < c.read ? c.read - z - 1 : c.end - z), A === 0)))
            return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); if (a = e, o = f, o > S && (o = S), o > A && (o = A), c.win.set(r.read_buf(v, o), z), v += o, S -= o, z += o, A -= o, (f -= o) != 0)
            break; d = g !== 0 ? j : D; break; case O:for (;k < 14;) {
          if (S === 0)
            return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); a = e, S--, l |= (255 & r.read_byte(v++)) << k, k += 8
        } if (h = o = 16383 & l, (31 & o) > 29 || (o >> 5 & 31) > 29)
            return d = L, r.msg = 'too many length or distance symbols', a = i, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); if (o = 258 + (31 & o) + (o >> 5 & 31), !u || u.length < o) {
            u = []
          }
          else {
            for (P = 0; P < o; P++)u[P] = 0
          }l >>>= 14, k -= 14, _ = 0, d = T; case T:for (;_ < 4 + (h >>> 10);) {
          for (;k < 3;) {
            if (S === 0)
              return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); a = e, S--, l |= (255 & r.read_byte(v++)) << k, k += 8
          }u[U[_++]] = 7 & l, l >>>= 3, k -= 3
        } for (;_ < 19;)u[U[_++]] = 0; if (b[0] = 7, o = x.inflate_trees_bits(u, b, p, y, r), o != e)
            return (a = o) == i && (u = null, d = L), c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); _ = 0, d = W; case W:for (;o = h, !(_ >= 258 + (31 & o) + (o >> 5 & 31));) {
          let t, n; for (o = b[0]; k < o;) {
            if (S === 0)
              return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); a = e, S--, l |= (255 & r.read_byte(v++)) << k, k += 8
          } if (o = y[3 * (p[0] + (l & s[o])) + 1], n = y[3 * (p[0] + (l & s[o])) + 2], n < 16) {
            l >>>= o, k -= o, u[_++] = n
          }
          else {
            for (P = n == 18 ? 7 : n - 14, t = n == 18 ? 11 : 3; k < o + P;) {
              if (S === 0)
                return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); a = e, S--, l |= (255 & r.read_byte(v++)) << k, k += 8
            } if (l >>>= o, k -= o, t += l & s[P], l >>>= P, k -= P, P = _, o = h, P + t > 258 + (31 & o) + (o >> 5 & 31) || n == 16 && P < 1)
              return u = null, d = L, r.msg = 'invalid bit length repeat', a = i, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); n = n == 16 ? u[P - 1] : 0; do { u[P++] = n } while (--t != 0); _ = P
          }
        } if (p[0] = -1, V = [], q = [], H = [], K = [], V[0] = 9, q[0] = 6, o = h, o = x.inflate_trees_dynamic(257 + (31 & o), 1 + (o >> 5 & 31), u, V, q, H, K, y, r), o != e)
            return o == i && (u = null, d = L), a = o, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); m.init(V[0], q[0], y, H[0], y, K[0]), d = C; case C:if (c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, (a = m.proc(c, r, a)) != t)
          return c.inflate_flush(r, a); if (a = e, m.free(r), v = r.next_in_index, S = r.avail_in, l = c.bitb, k = c.bitk, z = c.write, A = z < c.read ? c.read - z - 1 : c.end - z, g === 0) { d = D; break }d = j; case j:if (c.write = z, a = c.inflate_flush(r, a), z = c.write, A = z < c.read ? c.read - z - 1 : c.end - z, c.read != c.write)
          return c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); d = M; case M:return a = t, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); case L:return a = i, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a); default:return a = n, c.bitb = l, c.bitk = k, r.avail_in = S, r.total_in += v - r.next_in_index, r.next_in_index = v, c.write = z, c.inflate_flush(r, a)
      }
    }
  }, c.free = function (e) { c.reset(e, null), c.win = null, y = null }, c.set_dictionary = function (e, t, n) { c.win.set(e.subarray(t, t + n), 0), c.read = c.write = n }, c.sync_point = function () { return d == E ? 1 : 0 }
} const R = 13; const B = [0, 0, 255, 255]; function I() {
  const r = this; function s(t) { return t && t.istate ? (t.total_in = t.total_out = 0, t.msg = null, t.istate.mode = 7, t.istate.blocks.reset(t, null), e) : n }r.mode = 0, r.method = 0, r.was = [0], r.need = 0, r.marker = 0, r.wbits = 0, r.inflateEnd = function (t) { return r.blocks && r.blocks.free(t), r.blocks = null, e }, r.inflateInit = function (t, i) { return t.msg = null, r.blocks = null, i < 8 || i > 15 ? (r.inflateEnd(t), n) : (r.wbits = i, t.istate.blocks = new P(t, 1 << i), s(t), e) }, r.inflate = function (r, s) {
    let o, l; if (!r || !r.istate || !r.next_in)
      return n; const c = r.istate; for (s = s == 4 ? a : e, o = a; ;) {
      switch (c.mode) {
        case 0:if (r.avail_in === 0)
          return o; if (o = s, r.avail_in--, r.total_in++, (15 & (c.method = r.read_byte(r.next_in_index++))) != 8) { c.mode = R, r.msg = 'unknown compression method', c.marker = 5; break } if (8 + (c.method >> 4) > c.wbits) { c.mode = R, r.msg = 'invalid win size', c.marker = 5; break }c.mode = 1; case 1:if (r.avail_in === 0)
          return o; if (o = s, r.avail_in--, r.total_in++, l = 255 & r.read_byte(r.next_in_index++), ((c.method << 8) + l) % 31 != 0) { c.mode = R, r.msg = 'incorrect header check', c.marker = 5; break } if ((32 & l) == 0) { c.mode = 7; break }c.mode = 2; case 2:if (r.avail_in === 0)
          return o; o = s, r.avail_in--, r.total_in++, c.need = (255 & r.read_byte(r.next_in_index++)) << 24 & 4278190080, c.mode = 3; case 3:if (r.avail_in === 0)
          return o; o = s, r.avail_in--, r.total_in++, c.need += (255 & r.read_byte(r.next_in_index++)) << 16 & 16711680, c.mode = 4; case 4:if (r.avail_in === 0)
          return o; o = s, r.avail_in--, r.total_in++, c.need += (255 & r.read_byte(r.next_in_index++)) << 8 & 65280, c.mode = 5; case 5:return r.avail_in === 0 ? o : (o = s, r.avail_in--, r.total_in++, c.need += 255 & r.read_byte(r.next_in_index++), c.mode = 6, 2); case 6:return c.mode = R, r.msg = 'need dictionary', c.marker = 0, n; case 7:if (o = c.blocks.proc(r, o), o == i) { c.mode = R, c.marker = 0; break } if (o == e && (o = s), o != t)
          return o; o = s, c.blocks.reset(r, c.was), c.mode = 12; case 12:return r.avail_in = 0, t; case R:return i; default:return n
      }
    }
  }, r.inflateSetDictionary = function (t, i, r) {
    let a = 0; let s = r; if (!t || !t.istate || t.istate.mode != 6)
      return n; const o = t.istate; return s >= 1 << o.wbits && (s = (1 << o.wbits) - 1, a = r - s), o.blocks.set_dictionary(i, a, s), o.mode = 7, e
  }, r.inflateSync = function (t) {
    let r, o, l, c, u; if (!t || !t.istate)
      return n; const d = t.istate; if (d.mode != R && (d.mode = R, d.marker = 0), (r = t.avail_in) === 0)
      return a; for (o = t.next_in_index, l = d.marker; r !== 0 && l < 4;)t.read_byte(o) == B[l] ? l++ : l = t.read_byte(o) !== 0 ? 0 : 4 - l, o++, r--; return t.total_in += o - t.next_in_index, t.next_in_index = o, t.avail_in = r, d.marker = l, l != 4 ? i : (c = t.total_in, u = t.total_out, s(t), t.total_in = c, t.total_out = u, d.mode = 7, e)
  }, r.inflateSyncPoint = function (e) { return e && e.istate && e.istate.blocks ? e.istate.blocks.sync_point() : n }
} function N() {}N.prototype = { inflateInit(e) { const t = this; return t.istate = new I(), e || (e = 15), t.istate.inflateInit(t, e) }, inflate(e) { const t = this; return t.istate ? t.istate.inflate(t, e) : n }, inflateEnd() {
  const e = this; if (!e.istate)
    return n; const t = e.istate.inflateEnd(e); return e.istate = null, t
}, inflateSync() { const e = this; return e.istate ? e.istate.inflateSync(e) : n }, inflateSetDictionary(e, t) { const i = this; return i.istate ? i.istate.inflateSetDictionary(i, e, t) : n }, read_byte(e) { return this.next_in[e] }, read_buf(e, t) { return this.next_in.subarray(e, e + t) } }; const V = 4294967295; const q = 65535; const H = 33639248; const K = 101075792; const Z = 1; const G = void 0; const J = 'undefined'; const Q = 'function'; class X {constructor(e) { return class extends TransformStream {constructor(t, n) { const i = new e(n); super({ transform(e, t) { t.enqueue(i.append(e)) }, flush(e) { const t = i.flush(); t && e.enqueue(t) } }) }} }} let Y = 2; try { typeof navigator != J && navigator.hardwareConcurrency && (Y = navigator.hardwareConcurrency) }
catch (e) {} const $ = { chunkSize: 524288, maxWorkers: Y, terminateWorkerTimeout: 5e3, useWebWorkers: !0, useCompressionStream: !0, workerScripts: G, CompressionStreamNative: typeof CompressionStream != J && CompressionStream, DecompressionStreamNative: typeof DecompressionStream != J && DecompressionStream }; const ee = Object.assign({}, $); function te(e) {
  const { baseURL: t, chunkSize: n, maxWorkers: i, terminateWorkerTimeout: r, useCompressionStream: a, useWebWorkers: s, Deflate: o, Inflate: l, CompressionStream: c, DecompressionStream: u, workerScripts: d } = e; if (ne('baseURL', t), ne('chunkSize', n), ne('maxWorkers', i), ne('terminateWorkerTimeout', r), ne('useCompressionStream', a), ne('useWebWorkers', s), o && (ee.CompressionStream = new X(o)), l && (ee.DecompressionStream = new X(l)), ne('CompressionStream', c), ne('DecompressionStream', u), d !== G) {
    const { deflate: e, inflate: t } = d; if ((e || t) && (ee.workerScripts || (ee.workerScripts = {})), e) {
      if (!Array.isArray(e))
        throw new Error('workerScripts.deflate must be an array'); ee.workerScripts.deflate = e
    } if (t) {
      if (!Array.isArray(t))
        throw new Error('workerScripts.inflate must be an array'); ee.workerScripts.inflate = t
    }
  }
} function ne(e, t) { t !== G && (ee[e] = t) } const ie = []; for (let e = 0; e < 256; e++) { let t = e; for (let e = 0; e < 8; e++)1 & t ? t = t >>> 1 ^ 3988292384 : t >>>= 1; ie[e] = t } class re {constructor(e) { this.crc = e || -1 }append(e) { let t = 0 | this.crc; for (let n = 0, i = 0 | e.length; n < i; n++)t = t >>> 8 ^ ie[255 & (t ^ e[n])]; this.crc = t }get() { return ~this.crc }} class ae extends TransformStream {constructor() { let e; const t = new re(); super({ transform(e, n) { t.append(e), n.enqueue(e) }, flush() { const n = new Uint8Array(4); new DataView(n.buffer).setUint32(0, t.get()), e.value = n } }), e = this }} const se = { concat(e, t) {
  if (e.length === 0 || t.length === 0)
    return e.concat(t); const n = e[e.length - 1]; const i = se.getPartial(n); return i === 32 ? e.concat(t) : se._shiftRight(t, i, 0 | n, e.slice(0, e.length - 1))
}, bitLength(e) {
  const t = e.length; if (t === 0)
    return 0; const n = e[t - 1]; return 32 * (t - 1) + se.getPartial(n)
}, clamp(e, t) {
  if (32 * e.length < t)
    return e; const n = (e = e.slice(0, Math.ceil(t / 32))).length; return t &= 31, n > 0 && t && (e[n - 1] = se.partial(t, e[n - 1] & 2147483648 >> t - 1, 1)), e
}, partial: (e, t, n) => e === 32 ? t : (n ? 0 | t : t << 32 - e) + 1099511627776 * e, getPartial: e => Math.round(e / 1099511627776) || 32, _shiftRight(e, t, n, i) {
  for (void 0 === i && (i = []); t >= 32; t -= 32)i.push(n), n = 0; if (t === 0)
    return i.concat(e); for (let r = 0; r < e.length; r++)i.push(n | e[r] >>> t), n = e[r] << 32 - t; const r = e.length ? e[e.length - 1] : 0; const a = se.getPartial(r); return i.push(se.partial(t + a & 31, t + a > 32 ? n : i.pop(), 1)), i
} }; const oe = { bytes: { fromBits(e) { const t = se.bitLength(e) / 8; const n = new Uint8Array(t); let i; for (let r = 0; r < t; r++)(3 & r) == 0 && (i = e[r / 4]), n[r] = i >>> 24, i <<= 8; return n }, toBits(e) { const t = []; let n; let i = 0; for (n = 0; n < e.length; n++)i = i << 8 | e[n], (3 & n) == 3 && (t.push(i), i = 0); return 3 & n && t.push(se.partial(8 * (3 & n), i)), t } } }; const le = { sha1: class {
  constructor(e) { const t = this; t.blockSize = 512, t._init = [1732584193, 4023233417, 2562383102, 271733878, 3285377520], t._key = [1518500249, 1859775393, 2400959708, 3395469782], e ? (t._h = e._h.slice(0), t._buffer = e._buffer.slice(0), t._length = e._length) : t.reset() }reset() { const e = this; return e._h = e._init.slice(0), e._buffer = [], e._length = 0, e }update(e) {
    const t = this; typeof e == 'string' && (e = oe.utf8String.toBits(e)); const n = t._buffer = se.concat(t._buffer, e); const i = t._length; const r = t._length = i + se.bitLength(e); if (r > 9007199254740991)
      throw new Error('Cannot hash more than 2^53 - 1 bits'); const a = new Uint32Array(n); let s = 0; for (let e = t.blockSize + i - (t.blockSize + i & t.blockSize - 1); e <= r; e += t.blockSize)t._block(a.subarray(16 * s, 16 * (s + 1))), s += 1; return n.splice(0, 16 * s), t
  }

  finalize() { const e = this; let t = e._buffer; const n = e._h; t = se.concat(t, [se.partial(1, 1)]); for (let e = t.length + 2; 15 & e; e++)t.push(0); for (t.push(Math.floor(e._length / 4294967296)), t.push(0 | e._length); t.length;)e._block(t.splice(0, 16)); return e.reset(), n }_f(e, t, n, i) { return e <= 19 ? t & n | ~t & i : e <= 39 ? t ^ n ^ i : e <= 59 ? t & n | t & i | n & i : e <= 79 ? t ^ n ^ i : void 0 }_S(e, t) { return t << e | t >>> 32 - e }_block(e) { const t = this; const n = t._h; const i = Array.from({ length: 80 }); for (let t = 0; t < 16; t++)i[t] = e[t]; let r = n[0]; let a = n[1]; let s = n[2]; let o = n[3]; let l = n[4]; for (let e = 0; e <= 79; e++) { e >= 16 && (i[e] = t._S(1, i[e - 3] ^ i[e - 8] ^ i[e - 14] ^ i[e - 16])); const n = t._S(5, r) + t._f(e, a, s, o) + l + i[e] + t._key[Math.floor(e / 20)] | 0; l = o, o = s, s = t._S(30, a), a = r, r = n }n[0] = n[0] + r | 0, n[1] = n[1] + a | 0, n[2] = n[2] + s | 0, n[3] = n[3] + o | 0, n[4] = n[4] + l | 0 }
} }; const ce = { aes: class {
  constructor(e) {
    const t = this; t._tables = [[[], [], [], [], []], [[], [], [], [], []]], t._tables[0][0][0] || t._precompute(); const n = t._tables[0][4]; const i = t._tables[1]; const r = e.length; let a; let s; let o; let l = 1; if (r !== 4 && r !== 6 && r !== 8)
      throw new Error('invalid aes key size'); for (t._key = [s = e.slice(0), o = []], a = r; a < 4 * r + 28; a++) { let e = s[a - 1]; (a % r == 0 || r === 8 && a % r == 4) && (e = n[e >>> 24] << 24 ^ n[e >> 16 & 255] << 16 ^ n[e >> 8 & 255] << 8 ^ n[255 & e], a % r == 0 && (e = e << 8 ^ e >>> 24 ^ l << 24, l = l << 1 ^ 283 * (l >> 7))), s[a] = s[a - r] ^ e } for (let e = 0; a; e++, a--) { const t = s[3 & e ? a : a - 4]; o[e] = a <= 4 || e < 4 ? t : i[0][n[t >>> 24]] ^ i[1][n[t >> 16 & 255]] ^ i[2][n[t >> 8 & 255]] ^ i[3][n[255 & t]] }
  }

  encrypt(e) { return this._crypt(e, 0) }decrypt(e) { return this._crypt(e, 1) }_precompute() { const e = this._tables[0]; const t = this._tables[1]; const n = e[4]; const i = t[4]; const r = []; const a = []; let s, o, l, c; for (let e = 0; e < 256; e++)a[(r[e] = e << 1 ^ 283 * (e >> 7)) ^ e] = e; for (let u = s = 0; !n[u]; u ^= o || 1, s = a[s] || 1) { let a = s ^ s << 1 ^ s << 2 ^ s << 3 ^ s << 4; a = a >> 8 ^ 255 & a ^ 99, n[u] = a, i[a] = u, c = r[l = r[o = r[u]]]; let d = 16843009 * c ^ 65537 * l ^ 257 * o ^ 16843008 * u; let f = 257 * r[a] ^ 16843008 * a; for (let n = 0; n < 4; n++)e[n][u] = f = f << 24 ^ f >>> 8, t[n][a] = d = d << 24 ^ d >>> 8 } for (let n = 0; n < 5; n++)e[n] = e[n].slice(0), t[n] = t[n].slice(0) }_crypt(e, t) {
    if (e.length !== 4)
      throw new Error('invalid aes block size'); const n = this._key[t]; const i = n.length / 4 - 2; const r = [0, 0, 0, 0]; const a = this._tables[t]; const s = a[0]; const o = a[1]; const l = a[2]; const c = a[3]; const u = a[4]; let d; let f; let h; let _ = e[0] ^ n[0]; let w = e[t ? 3 : 1] ^ n[1]; let b = e[2] ^ n[2]; let p = e[t ? 1 : 3] ^ n[3]; let m = 4; for (let e = 0; e < i; e++)d = s[_ >>> 24] ^ o[w >> 16 & 255] ^ l[b >> 8 & 255] ^ c[255 & p] ^ n[m], f = s[w >>> 24] ^ o[b >> 16 & 255] ^ l[p >> 8 & 255] ^ c[255 & _] ^ n[m + 1], h = s[b >>> 24] ^ o[p >> 16 & 255] ^ l[_ >> 8 & 255] ^ c[255 & w] ^ n[m + 2], p = s[p >>> 24] ^ o[_ >> 16 & 255] ^ l[w >> 8 & 255] ^ c[255 & b] ^ n[m + 3], m += 4, _ = d, w = f, b = h; for (let e = 0; e < 4; e++)r[t ? 3 & -e : e] = u[_ >>> 24] << 24 ^ u[w >> 16 & 255] << 16 ^ u[b >> 8 & 255] << 8 ^ u[255 & p] ^ n[m++], d = _, _ = w, w = b, b = p, p = d; return r
  }
} }; const ue = { getRandomValues(e) { const t = new Uint32Array(e.buffer); const n = (e) => { let t = 987654321; const n = 4294967295; return function () { t = 36969 * (65535 & t) + (t >> 16) & n; return (((t << 16) + (e = 18e3 * (65535 & e) + (e >> 16) & n) & n) / 4294967296 + 0.5) * (Math.random() > 0.5 ? 1 : -1) } }; for (let i, r = 0; r < e.length; r += 4) { const e = n(4294967296 * (i || Math.random())); i = 987654071 * e(), t[r / 4] = 4294967296 * e() | 0 } return e } }; const de = { ctrGladman: class {
  constructor(e, t) { this._prf = e, this._initIv = t, this._iv = t }reset() { this._iv = this._initIv }update(e) { return this.calculate(this._prf, e, this._iv) }incWord(e) {
    if ((e >> 24 & 255) == 255) { let t = e >> 16 & 255; let n = e >> 8 & 255; let i = 255 & e; t === 255 ? (t = 0, n === 255 ? (n = 0, i === 255 ? i = 0 : ++i) : ++n) : ++t, e = 0, e += t << 16, e += n << 8, e += i }
    else {
      e += 1 << 24
    } return e
  }

  incCounter(e) { (e[0] = this.incWord(e[0])) === 0 && (e[1] = this.incWord(e[1])) }calculate(e, t, n) {
    let i; if (!(i = t.length))
      return []; const r = se.bitLength(t); for (let r = 0; r < i; r += 4) { this.incCounter(n); const i = e.encrypt(n); t[r] ^= i[0], t[r + 1] ^= i[1], t[r + 2] ^= i[2], t[r + 3] ^= i[3] } return se.clamp(t, r)
  }
} }; const fe = { importKey: e => new fe.hmacSha1(oe.bytes.toBits(e)), pbkdf2(e, t, n, i) {
  if (n = n || 1e4, i < 0 || n < 0)
    throw new Error('invalid params to pbkdf2'); const r = 1 + (i >> 5) << 2; let a, s, o, l, c; const u = new ArrayBuffer(r); const d = new DataView(u); let f = 0; const h = se; for (t = oe.bytes.toBits(t), c = 1; f < (r || 1); c++) {
    for (a = s = e.encrypt(h.concat(t, [c])), o = 1; o < n; o++) {
      for (s = e.encrypt(s), l = 0; l < s.length; l++)a[l] ^= s[l]
    } for (o = 0; f < (r || 1) && o < a.length; o++)d.setInt32(f, a[o]), f += 4
  } return u.slice(0, i / 8)
}, hmacSha1: class {
  constructor(e) { const t = this; const n = t._hash = le.sha1; const i = [[], []]; t._baseHash = [new n(), new n()]; const r = t._baseHash[0].blockSize / 32; e.length > r && (e = (new n()).update(e).finalize()); for (let t = 0; t < r; t++)i[0][t] = 909522486 ^ e[t], i[1][t] = 1549556828 ^ e[t]; t._baseHash[0].update(i[0]), t._baseHash[1].update(i[1]), t._resultHash = new n(t._baseHash[0]) }reset() { const e = this; e._resultHash = new e._hash(e._baseHash[0]), e._updated = !1 }update(e) { this._updated = !0, this._resultHash.update(e) }digest() { const e = this; const t = e._resultHash.finalize(); const n = new e._hash(e._baseHash[1]).update(t).finalize(); return e.reset(), n }encrypt(e) {
    if (this._updated)
      throw new Error('encrypt on already updated hmac called!'); return this.update(e), this.digest(e)
  }
} }; const he = typeof crypto != 'undefined' && typeof crypto.getRandomValues == 'function'; const _e = 'Invalid password'; const we = 'Invalid signature'; const be = 'zipjs-abort-check-password'; function pe(e) { return he ? crypto.getRandomValues(e) : ue.getRandomValues(e) } const me = 16; const ge = 'raw'; const ye = { name: 'PBKDF2' }; const xe = Object.assign({ hash: { name: 'HMAC' } }, ye); const ke = Object.assign({ iterations: 1e3, hash: { name: 'SHA-1' } }, ye); const ve = ['deriveBits']; const Se = [8, 12, 16]; const ze = [16, 24, 32]; const Ae = 10; const Ue = [0, 0, 0, 0]; const De = 'undefined'; const Ee = 'function'; const Fe = typeof crypto != De; const Oe = Fe && crypto.subtle; const Te = Fe && typeof Oe != De; const We = oe.bytes; const Ce = ce.aes; const je = de.ctrGladman; const Me = fe.hmacSha1; let Le = Fe && Te && typeof Oe.importKey == Ee; let Pe = Fe && Te && typeof Oe.deriveBits == Ee; class Re extends TransformStream {
  constructor({ password: e, signed: t, encryptionStrength: n, checkPasswordOnly: i }) {
    super({ start() { Object.assign(this, { ready: new Promise((e => this.resolveReady = e)), password: e, signed: t, strength: n - 1, pending: new Uint8Array() }) }, async transform(e, t) {
      const n = this; const { password: r, strength: a, resolveReady: s, ready: o } = n; r
        ? (await (async function (e, t, n, i) {
            const r = await Ne(e, t, n, qe(i, 0, Se[t])); const a = qe(i, Se[t]); if (r[0] != a[0] || r[1] != a[1])
              throw new Error(_e)
          }(n, a, r, qe(e, 0, Se[a] + 2))), e = qe(e, Se[a] + 2), i ? t.error(new Error(be)) : s())
        : await o; const l = new Uint8Array(e.length - Ae - (e.length - Ae) % me); t.enqueue(Ie(n, e, l, 0, Ae, !0))
    }, async flush(e) {
      const { signed: t, ctr: n, hmac: i, pending: r, ready: a } = this; if (i && n) {
        await a; const s = qe(r, 0, r.length - Ae); const o = qe(r, r.length - Ae); let l = new Uint8Array(); if (s.length) { const e = Ke(We, s); i.update(e); const t = n.update(e); l = He(We, t) } if (t) {
          const e = qe(He(We, i.digest()), 0, Ae); for (let t = 0; t < Ae; t++) {
            if (e[t] != o[t])
              throw new Error(we)
          }
        }e.enqueue(l)
      }
    } })
  }
} class Be extends TransformStream {constructor({ password: e, encryptionStrength: t }) { let n; super({ start() { Object.assign(this, { ready: new Promise((e => this.resolveReady = e)), password: e, strength: t - 1, pending: new Uint8Array() }) }, async transform(e, t) { const n = this; const { password: i, strength: r, resolveReady: a, ready: s } = n; let o = new Uint8Array(); i ? (o = await (async function (e, t, n) { const i = pe(new Uint8Array(Se[t])); const r = await Ne(e, t, n, i); return Ve(i, r) }(n, r, i)), a()) : await s; const l = new Uint8Array(o.length + e.length - e.length % me); l.set(o, 0), t.enqueue(Ie(n, e, l, o.length, 0)) }, async flush(e) { const { ctr: t, hmac: i, pending: r, ready: a } = this; if (i && t) { await a; let s = new Uint8Array(); if (r.length) { const e = t.update(Ke(We, r)); i.update(e), s = He(We, e) }n.signature = He(We, i.digest()).slice(0, Ae), e.enqueue(Ve(s, n.signature)) } } }), n = this }} function Ie(e, t, n, i, r, a) { const { ctr: s, hmac: o, pending: l } = e; const c = t.length - r; let u; for (l.length && (t = Ve(l, t), n = (function (e, t) { if (t && t > e.length) { const n = e; (e = new Uint8Array(t)).set(n, 0) } return e }(n, c - c % me))), u = 0; u <= c - me; u += me) { const e = Ke(We, qe(t, u, u + me)); a && o.update(e); const r = s.update(e); a || o.update(r), n.set(He(We, r), u + i) } return e.pending = qe(t, u), n } async function Ne(e, t, n, i) {
  e.password = null; const r = (function (e) { if (typeof TextEncoder == 'undefined') { e = unescape(encodeURIComponent(e)); const t = new Uint8Array(e.length); for (let n = 0; n < t.length; n++)t[n] = e.charCodeAt(n); return t } return (new TextEncoder()).encode(e) }(n)); const a = await (async function (e, t, n, i, r) {
    if (!Le)
      return fe.importKey(t); try { return await Oe.importKey(e, t, n, i, r) }
    catch (e) { return Le = !1, fe.importKey(t) }
  }(ge, r, xe, !1, ve)); const s = await (async function (e, t, n) {
    if (!Pe)
      return fe.pbkdf2(t, e.salt, ke.iterations, n); try { return await Oe.deriveBits(e, t, n) }
    catch (i) { return Pe = !1, fe.pbkdf2(t, e.salt, ke.iterations, n) }
  }(Object.assign({ salt: i }, ke), a, 8 * (2 * ze[t] + 2))); const o = new Uint8Array(s); const l = Ke(We, qe(o, 0, ze[t])); const c = Ke(We, qe(o, ze[t], 2 * ze[t])); const u = qe(o, 2 * ze[t]); return Object.assign(e, { keys: { key: l, authentication: c, passwordVerification: u }, ctr: new je(new Ce(l), Array.from(Ue)), hmac: new Me(c) }), u
} function Ve(e, t) { let n = e; return e.length + t.length && (n = new Uint8Array(e.length + t.length), n.set(e, 0), n.set(t, e.length)), n } function qe(e, t, n) { return e.subarray(t, n) } function He(e, t) { return e.fromBits(t) } function Ke(e, t) { return e.toBits(t) } const Ze = 12; class Ge extends TransformStream {
  constructor({ password: e, passwordVerification: t, checkPasswordOnly: n }) {
    super({ start() { Object.assign(this, { password: e, passwordVerification: t }), Ye(this, e) }, transform(e, t) {
      const i = this; if (i.password) {
        const t = Qe(i, e.subarray(0, Ze)); if (i.password = null, t[11] != i.passwordVerification)
          throw new Error(_e); e = e.subarray(Ze)
      }n ? t.error(new Error(be)) : t.enqueue(Qe(i, e))
    } })
  }
} class Je extends TransformStream {
  constructor({ password: e, passwordVerification: t }) {
    super({ start() { Object.assign(this, { password: e, passwordVerification: t }), Ye(this, e) }, transform(e, t) {
      const n = this; let i, r; if (n.password) { n.password = null; const t = pe(new Uint8Array(Ze)); t[11] = n.passwordVerification, i = new Uint8Array(e.length + t.length), i.set(Xe(n, t), 0), r = Ze }
      else {
        i = new Uint8Array(e.length), r = 0
      }i.set(Xe(n, e), r), t.enqueue(i)
    } })
  }
} function Qe(e, t) { const n = new Uint8Array(t.length); for (let i = 0; i < t.length; i++)n[i] = et(e) ^ t[i], $e(e, n[i]); return n } function Xe(e, t) { const n = new Uint8Array(t.length); for (let i = 0; i < t.length; i++)n[i] = et(e) ^ t[i], $e(e, t[i]); return n } function Ye(e, t) { const n = [305419896, 591751049, 878082192]; Object.assign(e, { keys: n, crcKey0: new re(n[0]), crcKey2: new re(n[2]) }); for (let n = 0; n < t.length; n++)$e(e, t.charCodeAt(n)) } function $e(e, t) { let [n, i, r] = e.keys; e.crcKey0.append([t]), n = ~e.crcKey0.get(), i = nt(Math.imul(nt(i + tt(n)), 134775813) + 1), e.crcKey2.append([i >>> 24]), r = ~e.crcKey2.get(), e.keys = [n, i, r] } function et(e) { const t = 2 | e.keys[2]; return tt(Math.imul(t, 1 ^ t) >>> 8) } function tt(e) { return 255 & e } function nt(e) { return 4294967295 & e } const it = 'deflate-raw'; class rt extends TransformStream {constructor(e, { chunkSize: t, CompressionStream: n, CompressionStreamNative: i }) { super({}); const { compressed: r, encrypted: a, useCompressionStream: s, zipCrypto: o, signed: l, level: c } = e; const u = this; let d; let f; let h = st(super.readable); a && !o || !l || (d = new ae(), h = ct(h, d)), r && (h = lt(h, s, { level: c, chunkSize: t }, i, n)), a && (o ? h = ct(h, new Je(e)) : (f = new Be(e), h = ct(h, f))), ot(u, h, () => { let e; a && !o && (e = f.signature), a && !o || !l || (e = new DataView(d.value.buffer).getUint32(0)), u.signature = e }) }} class at extends TransformStream {
  constructor(e, { chunkSize: t, DecompressionStream: n, DecompressionStreamNative: i }) {
    super({}); const { zipCrypto: r, encrypted: a, signed: s, signature: o, compressed: l, useCompressionStream: c } = e; let u; let d; let f = st(super.readable); a && (r ? f = ct(f, new Ge(e)) : (d = new Re(e), f = ct(f, d))), l && (f = lt(f, c, { chunkSize: t }, i, n)), a && !r || !s || (u = new ae(), f = ct(f, u)), ot(this, f, () => {
      if ((!a || r) && s) {
        const e = new DataView(u.value.buffer); if (o != e.getUint32(0, !1))
          throw new Error(we)
      }
    })
  }
} function st(e) { return ct(e, new TransformStream({ transform(e, t) { e && e.length && t.enqueue(e) } })) } function ot(e, t, n) { t = ct(t, new TransformStream({ flush: n })), Object.defineProperty(e, 'readable', { get: () => t }) } function lt(e, t, n, i, r) {
  try { e = ct(e, new (t && i ? i : r)(it, n)) }
  catch (i) {
    if (!t)
      throw i; e = ct(e, new r(it, n))
  } return e
} function ct(e, t) { return e.pipeThrough(t) } const ut = 'message'; const dt = 'start'; const ft = 'pull'; const ht = 'data'; const _t = 'ack'; const wt = 'close'; const bt = 'inflate'; class pt extends TransformStream {constructor(e, t) { super({}); const n = this; const { codecType: i } = e; let r; i.startsWith('deflate') ? r = rt : i.startsWith(bt) && (r = at); let a = 0; const s = new r(e, t); const o = super.readable; const l = new TransformStream({ transform(e, t) { e && e.length && (a += e.length, t.enqueue(e)) }, flush() { const { signature: e } = s; Object.assign(n, { signature: e, size: a }) } }); Object.defineProperty(n, 'readable', { get: () => o.pipeThrough(s).pipeThrough(l) }) }} const mt = typeof Worker != J; class gt {constructor(e, { readable: t, writable: n }, { options: i, config: r, streamOptions: a, useWebWorkers: s, transferStreams: o, scripts: l }, c) { const { signal: u } = a; return Object.assign(e, { busy: !0, readable: t.pipeThrough(new yt(t, a, r), { signal: u }), writable: n, options: Object.assign({}, i), scripts: l, transferStreams: o, terminate() { const { worker: t, busy: n } = e; t && !n && (t.terminate(), e.interface = null) }, onTaskFinished() { e.busy = !1, c(e) } }), (s && mt ? vt : kt)(e, r) }} class yt extends TransformStream {constructor(e, { onstart: t, onprogress: n, size: i, onend: r }, { chunkSize: a }) { let s = 0; super({ start() { t && xt(t, i) }, async transform(e, t) { s += e.length, n && await xt(n, s, i), t.enqueue(e) }, flush() { e.size = s, r && xt(r, s) } }, { highWaterMark: 1, size: () => a }) }} async function xt(e, ...t) {
  try { await e(...t) }
  catch (e) {}
} function kt(e, t) {
  return { run: () => (async function ({ options: e, readable: t, writable: n, onTaskFinished: i }, r) {
    const a = new pt(e, r); try { await t.pipeThrough(a).pipeTo(n, { preventClose: !0, preventAbort: !0 }); const { signature: e, size: i } = a; return { signature: e, size: i } }
    finally { i() }
  }(e, t)) }
} function vt(e, { baseURL: t, chunkSize: n }) {
  return e.interface || Object.assign(e, { worker: At(e.scripts[0], t, e), interface: { run: () => (async function (e, t) {
    let n, i; const r = new Promise(((e, t) => { n = e, i = t })); Object.assign(e, { reader: null, writer: null, resolveResult: n, rejectResult: i, result: r }); const { readable: a, options: s, scripts: o } = e; const { writable: l, closed: c } = (function (e) { const t = e.getWriter(); let n; const i = new Promise((e => n = e)); const r = new WritableStream({ async write(e) { await t.ready, await t.write(e) }, close() { t.releaseLock(), n() }, abort: e => t.abort(e) }); return { writable: r, closed: i } }(e.writable)); const u = Ut({ type: dt, scripts: o.slice(1), options: s, config: t, readable: a, writable: l }, e); u || Object.assign(e, { reader: a.getReader(), writer: l.getWriter() }); const d = await r; try { await l.getWriter().close() }
    catch (e) {} return await c, d
  }(e, { chunkSize: n })) } }), e.interface
} let St = !0; let zt = !0; function At(e, t, n) {
  const i = { type: 'module' }; let r, a; typeof e == Q && (e = e()); try { r = new URL(e, t) }
  catch (t) { r = e } if (St) {
    try { a = new Worker(r) }
    catch (e) { St = !1, a = new Worker(r, i) }
  }
  else {
    a = new Worker(r, i)
  } return a.addEventListener(ut, e => (async function ({ data: e }, t) {
    const { type: n, value: i, messageId: r, result: a, error: s } = e; const { reader: o, writer: l, resolveResult: c, rejectResult: u, onTaskFinished: d } = t; try {
      if (s) { const { message: e, stack: t, code: n, name: i } = s; const r = new Error(e); Object.assign(r, { stack: t, code: n, name: i }), f(r) }
      else { if (n == ft) { const { value: e, done: n } = await o.read(); Ut({ type: ht, value: e, done: n, messageId: r }, t) }n == ht && (await l.ready, await l.write(new Uint8Array(i)), Ut({ type: _t, messageId: r }, t)), n == wt && f(null, a) }
    }
    catch (s) { f(s) } function f(e, t) { e ? u(e) : c(t), l && l.releaseLock(), d() }
  }(e, n))), a
} function Ut(e, { worker: t, writer: n, onTaskFinished: i, transferStreams: r }) {
  try {
    const { value: n, readable: i, writable: a } = e; const s = []; if (n && (e.value = n.buffer, s.push(e.value)), r && zt ? (i && s.push(i), a && s.push(a)) : e.readable = e.writable = null, s.length) {
      try { return t.postMessage(e, s), !0 }
      catch (n) { zt = !1, e.readable = e.writable = null, t.postMessage(e) }
    }
    else {
      t.postMessage(e)
    }
  }
  catch (e) { throw n && n.releaseLock(), i(), e }
} let Dt = []; const Et = []; let Ft = 0; function Ot(e) { const { terminateTimeout: t } = e; t && (clearTimeout(t), e.terminateTimeout = null) } const Tt = 65536; const Wt = 'writable'; class Ct {constructor() { this.size = 0 }init() { this.initialized = !0 }} class jt extends Ct {get readable() { const e = this; const { chunkSize: t = Tt } = e; const n = new ReadableStream({ start() { this.chunkOffset = 0 }, async pull(i) { const { offset: r = 0, size: a, diskNumberStart: s } = n; const { chunkOffset: o } = this; i.enqueue(await Vt(e, r + o, Math.min(t, a - o), s)), o + t > a ? i.close() : this.chunkOffset += t } }); return n }} class Mt extends jt {constructor(e) { super(), Object.assign(this, { blob: e, size: e.size }) } async readUint8Array(e, t) { const n = this; const i = e + t; const r = e || i < n.size ? n.blob.slice(e, i) : n.blob; let a = await r.arrayBuffer(); return a.byteLength > t && (a = a.slice(e, i)), new Uint8Array(a) }} class Lt extends Ct {constructor(e) { super(); const t = new TransformStream(); const n = []; e && n.push(['Content-Type', e]), Object.defineProperty(this, Wt, { get: () => t.writable }), this.blob = new Response(t.readable, { headers: n }).blob() }getData() { return this.blob }} class Pt extends Lt {
  constructor(e) { super(e), Object.assign(this, { encoding: e, utf8: !e || e.toLowerCase() == 'utf-8' }) } async getData() {
    const { encoding: e, utf8: t } = this; const n = await super.getData(); if (n.text && t)
      return n.text(); { const t = new FileReader(); return new Promise(((i, r) => { Object.assign(t, { onload: ({ target: e }) => i(e.result), onerror: () => r(t.error) }), t.readAsText(n, e) })) }
  }
} class Rt extends jt {
  constructor(e) { super(), this.readers = e } async init() { const e = this; const { readers: t } = e; e.lastDiskNumber = 0, e.lastDiskOffset = 0, await Promise.all(t.map((async (n, i) => { await n.init(), i != t.length - 1 && (e.lastDiskOffset += n.size), e.size += n.size }))), super.init() } async readUint8Array(e, t, n = 0) {
    const i = this; const { readers: r } = this; let a; let s = n; s == -1 && (s = r.length - 1); let o = e; for (;o >= r[s].size;)o -= r[s].size, s++; const l = r[s]; const c = l.size; if (o + t <= c) {
      a = await Vt(l, o, t)
    }
    else { const r = c - o; a = new Uint8Array(t), a.set(await Vt(l, o, r)), a.set(await i.readUint8Array(e + r, t - r, n), r) } return i.lastDiskNumber = Math.max(s, i.lastDiskNumber), a
  }
} class Bt extends Ct {
  constructor(e, t = 4294967295) {
    super(); const n = this; let i, r, a; Object.assign(n, { diskNumber: 0, diskOffset: 0, size: 0, maxSize: t, availableSize: t }); const s = new WritableStream({ async write(t) {
      const { availableSize: s } = n; if (a) {
        t.length >= s ? (await o(t.slice(0, s)), await l(), n.diskOffset += i.size, n.diskNumber++, a = null, await this.write(t.slice(s))) : await o(t)
      }
      else {
        const { value: s, done: o } = await e.next(); if (o && !s)
          throw new Error('Writer iterator completed too soon'); i = s, i.size = 0, i.maxSize && (n.maxSize = i.maxSize), n.availableSize = n.maxSize, await It(i), r = s.writable, a = r.getWriter(), await this.write(t)
      }
    }, async close() { await a.ready, await l() } }); async function o(e) { const t = e.length; t && (await a.ready, await a.write(e), i.size += t, n.size += t, n.availableSize -= t) } async function l() { r.size = i.size, await a.close() }Object.defineProperty(n, Wt, { get: () => s })
  }
} async function It(e, t) { e.init && !e.initialized && await e.init(t) } function Nt(e) { return Array.isArray(e) && (e = new Rt(e)), e instanceof ReadableStream && (e = { readable: e }), e } function Vt(e, t, n, i) { return e.readUint8Array(t, n, i) } const qt = '\0☺☻♥♦♣♠•◘○◙♂♀♪♫☼►◄↕‼¶§▬↨↑↓→←∟↔▲▼ !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~⌂ÇüéâäàåçêëèïîìÄÅÉæÆôöòûùÿÖÜ¢£¥₧ƒáíóúñÑªº¿⌐¬½¼¡«»░▒▓│┤╡╢╖╕╣║╗╝╜╛┐└┴┬├─┼╞╟╚╔╩╦╠═╬╧╨╤╥╙╘╒╓╫╪┘┌█▄▌▐▀αßΓπΣσµτΦΘΩδ∞φε∩≡±≥≤⌠⌡÷≈°∙·√ⁿ²■ '.split(''); const Ht = qt.length == 256; function Kt(e, t) { return t && t.trim().toLowerCase() == 'cp437' ? (function (e) { if (Ht) { let t = ''; for (let n = 0; n < e.length; n++)t += qt[e[n]]; return t } return (new TextDecoder()).decode(e) }(e)) : new TextDecoder(t).decode(e) } const Zt = 'filename'; const Gt = 'rawFilename'; const Jt = 'comment'; const Qt = 'rawComment'; const Xt = 'uncompressedSize'; const Yt = 'compressedSize'; const $t = 'offset'; const en = 'diskNumberStart'; const tn = 'lastModDate'; const nn = 'rawLastModDate'; const rn = 'lastAccessDate'; const an = 'rawLastAccessDate'; const sn = 'creationDate'; const on = 'rawCreationDate'; const ln = [Zt, Gt, Yt, Xt, tn, nn, Jt, Qt, rn, sn, $t, en, en, 'internalFileAttribute', 'externalFileAttribute', 'msDosCompatible', 'zip64', 'directory', 'bitFlag', 'encrypted', 'signature', 'filenameUTF8', 'commentUTF8', 'compressionMethod', 'version', 'versionMadeBy', 'extraField', 'rawExtraField', 'extraFieldZip64', 'extraFieldUnicodePath', 'extraFieldUnicodeComment', 'extraFieldAES', 'extraFieldNTFS', 'extraFieldExtendedTimestamp']; class cn {constructor(e) { ln.forEach((t => this[t] = e[t])) }} const un = 'File format is not recognized'; const dn = 'Zip64 extra field not found'; const fn = 'Compression method not supported'; const hn = 'Split zip file'; const _n = 'utf-8'; const wn = 'cp437'; const bn = [[Xt, V], [Yt, V], [$t, V], [en, q]]; const pn = { [q]: { getValue: Dn, bytes: 4 }, [V]: { getValue: En, bytes: 8 } }; class mn {
  constructor(e, t = {}) { Object.assign(this, { reader: Nt(e), options: t, config: ee }) } async*getEntriesGenerator(e = {}) {
    const t = this; let { reader: n } = t; const { config: i } = t; if (await It(n), n.size !== G && n.readUint8Array || (n = new Mt(await new Response(n.readable).blob()), await It(n)), n.size < 22)
      throw new Error(un); n.chunkSize = (function (e) { return Math.max(e.chunkSize, 64) }(i)); const r = await (async function (e, t, n, i, r) {
      const a = new Uint8Array(4); !(function (e, t, n) { e.setUint32(t, n, !0) }(Fn(a), 0, t)); const s = i + r; return await o(i) || await o(Math.min(s, n)); async function o(t) {
        const r = n - t; const s = await Vt(e, r, t); for (let e = s.length - i; e >= 0; e--) {
          if (s[e] == a[0] && s[e + 1] == a[1] && s[e + 2] == a[2] && s[e + 3] == a[3])
            return { offset: r + e, buffer: s.slice(e, e + i).buffer }
        }
      }
    }(n, 101010256, n.size, 22, 1048560)); if (!r) { throw Dn(Fn(await Vt(n, 0, 4))) == 134695760 ? new Error(hn) : new Error('End of central directory not found') } const a = Fn(r); let s = Dn(a, 12); let o = Dn(a, 16); const l = r.offset; const c = Un(a, 20); const u = l + 22 + c; let d = Un(a, 4); const f = n.lastDiskNumber || 0; let h = Un(a, 6); let _ = Un(a, 8); let w = 0; let b = 0; if (o == V || s == V || _ == q || h == q) {
      const e = Fn(await Vt(n, r.offset - 20, 20)); if (Dn(e, 0) != 117853008)
        throw new Error('End of Zip64 central directory not found'); o = En(e, 8); let t = await Vt(n, o, 56, -1); let i = Fn(t); const a = r.offset - 20 - 56; if (Dn(i, 0) != K && o != a) { const e = o; o = a, w = o - e, t = await Vt(n, o, 56, -1), i = Fn(t) } if (Dn(i, 0) != K)
        throw new Error('End of Zip64 central directory locator not found'); d == q && (d = Dn(i, 16)), h == q && (h = Dn(i, 20)), _ == q && (_ = En(i, 32)), s == V && (s = En(i, 40)), o -= s
    } if (f != d)
      throw new Error(hn); if (o < 0 || o >= n.size)
      throw new Error(un); let p = 0; let m = await Vt(n, o, s, h); let g = Fn(m); if (s) { const e = r.offset - s; if (Dn(g, p) != H && o != e) { const t = o; o = e, w = o - t, m = await Vt(n, o, s, h), g = Fn(m) } } const y = r.offset - o - (n.lastDiskOffset || 0); if (s != y && y >= 0 && (s = y, m = await Vt(n, o, s, h), g = Fn(m)), o < 0 || o >= n.size)
      throw new Error(un); const x = vn(t, e, 'filenameEncoding'); const k = vn(t, e, 'commentEncoding'); for (let r = 0; r < _; r++) {
      const a = new gn(n, i, t.options); if (Dn(g, p) != H)
        throw new Error('Central directory header not found'); yn(a, g, p + 6); const s = Boolean(a.bitFlag.languageEncodingFlag); const o = p + 46; const l = o + a.filenameLength; const c = l + a.extraFieldLength; const u = Un(g, p + 4); const d = (0 & u) == 0; const f = m.subarray(o, l); const h = Un(g, p + 32); const y = c + h; const v = m.subarray(c, y); const S = s; const z = s; const A = d && (16 & An(g, p + 38)) == 16; const U = Dn(g, p + 42) + w; Object.assign(a, { versionMadeBy: u, msDosCompatible: d, compressedSize: 0, uncompressedSize: 0, commentLength: h, directory: A, offset: U, diskNumberStart: Un(g, p + 34), internalFileAttribute: Un(g, p + 36), externalFileAttribute: Dn(g, p + 38), rawFilename: f, filenameUTF8: S, commentUTF8: z, rawExtraField: m.subarray(l, c) }); const [D, E] = await Promise.all([Kt(f, S ? _n : x || wn), Kt(v, z ? _n : k || wn)]); Object.assign(a, { rawComment: v, filename: D, comment: E, directory: A || D.endsWith('/') }), b = Math.max(U, b), await xn(a, a, g, p + 6); const F = new cn(a); F.getData = (e, t) => a.getData(e, F, t), p = y; const { onprogress: O } = e; if (O) {
        try { await O(r + 1, _, new cn(a)) }
        catch (e) {}
      } yield F
    } const v = vn(t, e, 'extractPrependedData'); const S = vn(t, e, 'extractAppendedData'); return v && (t.prependedData = b > 0 ? await Vt(n, 0, b) : new Uint8Array()), t.comment = c ? await Vt(n, l + 22, c) : new Uint8Array(), S && (t.appendedData = u < n.size ? await Vt(n, u, n.size - u) : new Uint8Array()), !0
  }

  async getEntries(e = {}) { const t = []; for await (const n of this.getEntriesGenerator(e))t.push(n); return t } async close() {}
} class gn {
  constructor(e, t, n) { Object.assign(this, { reader: e, config: t, options: n }) } async getData(e, t, n = {}) {
    const i = this; const { reader: r, offset: a, diskNumberStart: s, extraFieldAES: o, compressionMethod: l, config: c, bitFlag: u, signature: d, rawLastModDate: f, uncompressedSize: h, compressedSize: _ } = i; const w = t.localDirectory = {}; const b = Fn(await Vt(r, a, 30, s)); let p = vn(i, n, 'password'); if (p = p && p.length && p, o && o.originalCompressionMethod != 99)
      throw new Error(fn); if (l != 0 && l != 8)
      throw new Error(fn); if (Dn(b, 0) != 67324752)
      throw new Error('Local file header not found'); yn(w, b, 4), w.rawExtraField = w.extraFieldLength ? await Vt(r, a + 30 + w.filenameLength, w.extraFieldLength, s) : new Uint8Array(), await xn(i, w, b, 4, !0), Object.assign(t, { lastAccessDate: w.lastAccessDate, creationDate: w.creationDate }); const m = i.encrypted && w.encrypted; const g = m && !o; if (m) {
      if (!g && o.strength === G)
        throw new Error('Encryption method not supported'); if (!p)
        throw new Error('File contains encrypted entry')
    } const y = a + 30 + w.filenameLength + w.extraFieldLength; const x = _; const k = r.readable; Object.assign(k, { diskNumberStart: s, offset: y, size: x }); const v = vn(i, n, 'signal'); const S = vn(i, n, 'checkPasswordOnly'); S && (e = new WritableStream()), e = (function (e) { e.writable === G && typeof e.next == Q && (e = new Bt(e)), e instanceof WritableStream && (e = { writable: e }); const { writable: t } = e; return t.size === G && (t.size = 0), e instanceof Bt || Object.assign(e, { diskNumber: 0, diskOffset: 0, availableSize: 1 / 0, maxSize: 1 / 0 }), e }(e)), await It(e, h); const { writable: z } = e; const { onstart: A, onprogress: U, onend: D } = n; const E = { options: { codecType: bt, password: p, zipCrypto: g, encryptionStrength: o && o.strength, signed: vn(i, n, 'checkSignature'), passwordVerification: g && (u.dataDescriptor ? f >>> 8 & 255 : d >>> 24 & 255), signature: d, compressed: l != 0, encrypted: m, useWebWorkers: vn(i, n, 'useWebWorkers'), useCompressionStream: vn(i, n, 'useCompressionStream'), transferStreams: vn(i, n, 'transferStreams'), checkPasswordOnly: S }, config: c, streamOptions: { signal: v, size: x, onstart: A, onprogress: U, onend: D } }; let F = 0; try {
      ({ outputSize: F } = await (async function (e, t) {
        const { options: n, config: i } = t; const { transferStreams: r, useWebWorkers: a, useCompressionStream: s, codecType: o, compressed: l, signed: c, encrypted: u } = n; const { workerScripts: d, maxWorkers: f, terminateWorkerTimeout: h } = i; t.transferStreams = r || r === G; const _ = !(l || c || u || t.transferStreams); let w; t.useWebWorkers = !_ && (a || a === G && i.useWebWorkers), t.scripts = t.useWebWorkers && d ? d[o] : [], n.useCompressionStream = s || s === G && i.useCompressionStream; const b = Dt.find((e => !e.busy)); if (b) {
          Ot(b), w = new gt(b, e, t, p)
        }
        else if (Dt.length < f) { const n = { indexWorker: Ft }; Ft++, Dt.push(n), w = new gt(n, e, t, p) }
        else {
          w = await new Promise((n => Et.push({ resolve: n, stream: e, workerOptions: t })))
        } return w.run(); function p(e) {
          if (Et.length) { const [{ resolve: t, stream: n, workerOptions: i }] = Et.splice(0, 1); t(new gt(e, n, i, p)) }
          else {
            e.worker ? (Ot(e), Number.isFinite(h) && h >= 0 && (e.terminateTimeout = setTimeout(() => { Dt = Dt.filter((t => t != e)), e.terminate() }, h))) : Dt = Dt.filter((t => t != e))
          }
        }
      }({ readable: k, writable: z }, E)))
    }
    catch (e) {
      if (!S || e.message != be)
        throw e
    }
    finally { const e = vn(i, n, 'preventClose'); z.size += F, e || z.locked || await z.getWriter().close() } return S ? void 0 : e.getData ? e.getData() : z
  }
} function yn(e, t, n) { const i = e.rawBitFlag = Un(t, n + 2); const r = (1 & i) == 1; const a = Dn(t, n + 6); Object.assign(e, { encrypted: r, version: Un(t, n), bitFlag: { level: (6 & i) >> 1, dataDescriptor: (8 & i) == 8, languageEncodingFlag: (2048 & i) == 2048 }, rawLastModDate: a, lastModDate: Sn(a), filenameLength: Un(t, n + 22), extraFieldLength: Un(t, n + 24) }) } async function xn(e, t, n, i, r) {
  const { rawExtraField: a } = t; const s = t.extraField = new Map(); const o = Fn(new Uint8Array(a)); let l = 0; try { for (;l < a.length;) { const e = Un(o, l); const t = Un(o, l + 2); s.set(e, { type: e, data: a.slice(l + 4, l + 4 + t) }), l += 4 + t } }
  catch (e) {} const c = Un(n, i + 4); Object.assign(t, { signature: Dn(n, i + 10), uncompressedSize: Dn(n, i + 18), compressedSize: Dn(n, i + 14) }); const u = s.get(1); u && (!(function (e, t) {
    t.zip64 = !0; const n = Fn(e.data); const i = bn.filter((([e, n]) => t[e] == n)); for (let r = 0, a = 0; r < i.length; r++) {
      const [s, o] = i[r]; if (t[s] == o) { const i = pn[o]; t[s] = e[s] = i.getValue(n, a), a += i.bytes }
      else if (e[s]) {
        throw new Error(dn)
      }
    }
  }(u, t)), t.extraFieldZip64 = u); const d = s.get(28789); d && (await kn(d, Zt, Gt, t, e), t.extraFieldUnicodePath = d); const f = s.get(25461); f && (await kn(f, Jt, Qt, t, e), t.extraFieldUnicodeComment = f); const h = s.get(39169); h ? (!(function (e, t, n) { const i = Fn(e.data); const r = An(i, 4); Object.assign(e, { vendorVersion: An(i, 0), vendorId: An(i, 2), strength: r, originalCompressionMethod: n, compressionMethod: Un(i, 5) }), t.compressionMethod = e.compressionMethod }(h, t, c)), t.extraFieldAES = h) : t.compressionMethod = c; const _ = s.get(10); _ && (!(function (e, t) {
    const n = Fn(e.data); let i; let r = 4; try { for (;r < e.data.length && !i;) { const t = Un(n, r); const a = Un(n, r + 2); t == Z && (i = e.data.slice(r + 4, r + 4 + a)), r += 4 + a } }
    catch (e) {} try { if (i && i.length == 24) { const n = Fn(i); const r = n.getBigUint64(0, !0); const a = n.getBigUint64(8, !0); const s = n.getBigUint64(16, !0); Object.assign(e, { rawLastModDate: r, rawLastAccessDate: a, rawCreationDate: s }); const o = zn(r); const l = zn(a); const c = { lastModDate: o, lastAccessDate: l, creationDate: zn(s) }; Object.assign(e, c), Object.assign(t, c) } }
    catch (e) {}
  }(_, t)), t.extraFieldNTFS = _); const w = s.get(21589); w && (!(function (e, t, n) { const i = Fn(e.data); const r = An(i, 0); const a = []; const s = []; n ? ((1 & r) == 1 && (a.push(tn), s.push(nn)), (2 & r) == 2 && (a.push(rn), s.push(an)), (4 & r) == 4 && (a.push(sn), s.push(on))) : e.data.length >= 5 && (a.push(tn), s.push(nn)); let o = 1; a.forEach(((n, r) => { if (e.data.length >= o + 4) { const a = Dn(i, o); t[n] = e[n] = new Date(1e3 * a); const l = s[r]; e[l] = a }o += 4 })) }(w, t, r)), t.extraFieldExtendedTimestamp = w); const b = s.get(6534); b && (t.extraFieldUSDZ = b)
} async function kn(e, t, n, i, r) { const a = Fn(e.data); const s = new re(); s.append(r[n]); const o = Fn(new Uint8Array(4)); o.setUint32(0, s.get(), !0); const l = Dn(a, 1); Object.assign(e, { version: An(a, 0), [t]: Kt(e.data.subarray(5)), valid: !r.bitFlag.languageEncodingFlag && l == Dn(o, 0) }), e.valid && (i[t] = e[t], i[`${t}UTF8`] = !0) } function vn(e, t, n) { return t[n] === G ? e.options[n] : t[n] } function Sn(e) {
  const t = (4294901760 & e) >> 16; const n = 65535 & e; try { return new Date(1980 + ((65024 & t) >> 9), ((480 & t) >> 5) - 1, 31 & t, (63488 & n) >> 11, (2016 & n) >> 5, 2 * (31 & n), 0) }
  catch (e) {}
} function zn(e) { return new Date(Number(e / BigInt(1e4) - BigInt(116444736e5))) } function An(e, t) { return e.getUint8(t) } function Un(e, t) { return e.getUint16(t, !0) } function Dn(e, t) { return e.getUint32(t, !0) } function En(e, t) { return Number(e.getBigUint64(t, !0)) } function Fn(e) { return new DataView(e.buffer) }te({ Inflate(n) {
  const i = new N(); const r = n && n.chunkSize ? Math.floor(2 * n.chunkSize) : 131072; const s = new Uint8Array(r); let o = !1; i.inflateInit(), i.next_out = s, this.append = function (n, l) {
    const c = []; let u; let d; let f = 0; let h = 0; let _ = 0; if (n.length !== 0) {
      i.next_in_index = 0, i.next_in = n, i.avail_in = n.length; do {
        if (i.next_out_index = 0, i.avail_out = r, i.avail_in !== 0 || o || (i.next_in_index = 0, o = !0), u = i.inflate(0), o && u === a) {
          if (i.avail_in !== 0)
            throw new Error('inflating: bad input')
        }
        else if (u !== e && u !== t) {
          throw new Error(`inflating: ${i.msg}`)
        } if ((o || u === t) && i.avail_in === n.length)
          throw new Error('inflating: bad input'); i.next_out_index && (i.next_out_index === r ? c.push(new Uint8Array(s)) : c.push(s.subarray(0, i.next_out_index))), _ += i.next_out_index, l && i.next_in_index > 0 && i.next_in_index != f && (l(i.next_in_index), f = i.next_in_index)
      } while (i.avail_in > 0 || i.avail_out === 0); return c.length > 1 ? (d = new Uint8Array(_), c.forEach(((e) => { d.set(e, h), h += e.length }))) : d = c[0] ? new Uint8Array(c[0]) : new Uint8Array(), d
    }
  }, this.flush = function () { i.inflateEnd() }
} }); export { Lt as BlobWriter, mn as ZipReader, Mt as BlobReader, Pt as TextWriter, te as configure }
