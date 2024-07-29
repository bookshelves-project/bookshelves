const r = Uint8Array; const e = Uint16Array; const a = Uint32Array; const n = new r([0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 0, 0, 0, 0]); const t = new r([0, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13, 0, 0]); const i = new r([16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15]); const f = function (r, n) {
  for (var t = new e(31), i = 0; i < 31; ++i)t[i] = n += 1 << r[i - 1]; const f = new a(t[30]); for (i = 1; i < 30; ++i) {
    for (let o = t[i]; o < t[i + 1]; ++o)f[o] = o - t[i] << 5 | i
  } return [t, f]
}; const o = f(n, 2); const v = o[0]; const l = o[1]; v[28] = 258, l[258] = 28; for (var u = f(t, 0)[0], c = new e(32768), d = 0; d < 32768; ++d) { let s = (43690 & d) >>> 1 | (21845 & d) << 1; s = (61680 & (s = (52428 & s) >>> 2 | (13107 & s) << 2)) >>> 4 | (3855 & s) << 4, c[d] = ((65280 & s) >>> 8 | (255 & s) << 8) >>> 1 } const w = function (r, a, n) {
  for (var t = r.length, i = 0, f = new e(a); i < t; ++i)r[i] && ++f[r[i] - 1]; let o; const v = new e(a); for (i = 0; i < a; ++i)v[i] = v[i - 1] + f[i - 1] << 1; if (n) {
    o = new e(1 << a); const l = 15 - a; for (i = 0; i < t; ++i) {
      if (r[i]) {
        for (let u = i << 4 | r[i], d = a - r[i], s = v[r[i] - 1]++ << d, w = s | (1 << d) - 1; s <= w; ++s)o[c[s] >>> l] = u
      }
    }
  }
  else {
    for (o = new e(t), i = 0; i < t; ++i)r[i] && (o[i] = c[v[r[i] - 1]++] >>> 15 - r[i])
  } return o
}; const b = new r(288); for (d = 0; d < 144; ++d)b[d] = 8; for (d = 144; d < 256; ++d)b[d] = 9; for (d = 256; d < 280; ++d)b[d] = 7; for (d = 280; d < 288; ++d)b[d] = 8; const h = new r(32); for (d = 0; d < 32; ++d)h[d] = 5; const E = w(b, 9, 1); const p = w(h, 5, 1); const g = function (r) { for (var e = r[0], a = 1; a < r.length; ++a)r[a] > e && (e = r[a]); return e }; const y = function (r, e, a) { const n = e / 8 | 0; return (r[n] | r[n + 1] << 8) >> (7 & e) & a }; const k = function (r, e) { const a = e / 8 | 0; return (r[a] | r[a + 1] << 8 | r[a + 2] << 16) >> (7 & e) }; const T = ['unexpected EOF', 'invalid block type', 'invalid length/literal', 'invalid distance', 'stream finished', 'no stream handler',,'no callback', 'invalid UTF-8 data', 'extra field too long', 'date not in range 1980-2099', 'filename too long', 'stream finishing', 'invalid zip data']; const m = function (r, e, a) {
  const n = new Error(e || T[r]); if (n.code = r, Error.captureStackTrace && Error.captureStackTrace(n, m), !a)
    throw n; return n
}; const x = function (f, o, l) {
  const c = f.length; if (!c || l && l.f && !l.l)
    return o || new r(0); const d = !o || l; const s = !l || l.i; l || (l = {}), o || (o = new r(3 * c)); const b = function (e) { const a = o.length; if (e > a) { const n = new r(Math.max(2 * a, e)); n.set(o), o = n } }; let h = l.f || 0; let T = l.p || 0; let x = l.b || 0; let S = l.l; let U = l.d; let _ = l.m; let z = l.n; const A = 8 * c; do {
    if (!S) {
      h = y(f, T, 1); const M = y(f, T + 1, 3); if (T += 3, !M) { const B = f[(C = 4 + ((T + 7) / 8 | 0)) - 4] | f[C - 3] << 8; const D = C + B; if (D > c) { s && m(0); break }d && b(x + B), o.set(f.subarray(C, D), x), l.b = x += B, l.p = T = 8 * D, l.f = h; continue } if (M == 1) {
        S = E, U = p, _ = 9, z = 5
      }
      else if (M == 2) {
        const F = y(f, T, 31) + 257; const L = y(f, T + 10, 15) + 4; const N = F + y(f, T + 5, 31) + 1; T += 14; for (var P = new r(N), R = new r(19), Y = 0; Y < L; ++Y)R[i[Y]] = y(f, T + 3 * Y, 7); T += 3 * L; const O = g(R); const j = (1 << O) - 1; const q = w(R, O, 1); for (Y = 0; Y < N;) {
          var C; const G = q[y(f, T, j)]; if (T += 15 & G, (C = G >>> 4) < 16) {
            P[Y++] = C
          }
          else { var H = 0; let I = 0; for (C == 16 ? (I = 3 + y(f, T, 3), T += 2, H = P[Y - 1]) : C == 17 ? (I = 3 + y(f, T, 7), T += 3) : C == 18 && (I = 11 + y(f, T, 127), T += 7); I--;)P[Y++] = H }
        } const J = P.subarray(0, F); var K = P.subarray(F); _ = g(J), z = g(K), S = w(J, _, 1), U = w(K, z, 1)
      }
      else {
        m(1)
      } if (T > A) { s && m(0); break }
    }d && b(x + 131072); for (var Q = (1 << _) - 1, V = (1 << z) - 1, W = T; ;W = T) {
      const X = (H = S[k(f, T) & Q]) >>> 4; if ((T += 15 & H) > A) { s && m(0); break } if (H || m(2), X < 256) {
        o[x++] = X
      }
      else { if (X == 256) { W = T, S = null; break } let Z = X - 254; if (X > 264) { var $ = n[Y = X - 257]; Z = y(f, T, (1 << $) - 1) + v[Y], T += $ } const rr = U[k(f, T) & V]; const er = rr >>> 4; rr || m(3), T += 15 & rr; K = u[er]; if (er > 3) { $ = t[er]; K += k(f, T) & (1 << $) - 1, T += $ } if (T > A) { s && m(0); break }d && b(x + 131072); for (var ar = x + Z; x < ar; x += 4)o[x] = o[x - K], o[x + 1] = o[x + 1 - K], o[x + 2] = o[x + 2 - K], o[x + 3] = o[x + 3 - K]; x = ar }
    }l.l = S, l.p = W, l.b = x, l.f = h, S && (h = 1, l.m = _, l.d = U, l.n = z)
  } while (!h); return x == o.length ? o : (function (n, t, i) { (t == null || t < 0) && (t = 0), (i == null || i > n.length) && (i = n.length); const f = new (n.BYTES_PER_ELEMENT == 2 ? e : n.BYTES_PER_ELEMENT == 4 ? a : r)(i - t); return f.set(n.subarray(t, i)), f }(o, 0, x))
}; const S = new r(0); function U(r, e) { return x((((15 & (a = r)[0]) != 8 || a[0] >>> 4 > 7 || (a[0] << 8 | a[1]) % 31) && m(6, 'invalid zlib data'), 32 & a[1] && m(6, 'invalid zlib data: preset dictionaries not supported'), r.subarray(2, -4)), e); let a } const _ = typeof TextDecoder != 'undefined' && new TextDecoder(); try { _.decode(S, { stream: !0 }), 1 }
catch (r) {} export { U as unzlibSync }
