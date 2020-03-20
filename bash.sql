    SELECT DISTINCT
            pst_detail.KD_KECAMATAN_PEMOHON, pst_detail.KD_KELURAHAN_PEMOHON,
            ref_kecamatan.NM_KECAMATAN, ref_kelurahan.NM_KELURAHAN,
            pst_detail.THN_PELAYANAN, pst_detail.BUNDEL_PELAYANAN, pst_detail.NO_URUT_PELAYANAN,
            pst_detail.TGL_SELESAI, pst_detail.TGL_PENYERAHAN,
            -- pst_detail.KD_JNS_PELAYANAN,pst_detail.TGL_SELESAI,
            (SELECT COUNT(pst_detail.KD_JNS_PELAYANAN) 
                FROM pst_detail 
                    WHERE pst_detail.KD_JNS_PELAYANAN       = 1 
                        AND pst_detail.THN_PELAYANAN        = 2020 
                        AND pst_detail.BUNDEL_PELAYANAN     = 4 
                        AND pst_detail.NO_URUT_PELAYANAN    = 20
                        AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
                        AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON
            ) AS OP_BARU,

            (SELECT COUNT(*)
                FROM pst_detail 
                    WHERE (pst_detail.KD_JNS_PELAYANAN      = 2 OR pst_detail.KD_JNS_PELAYANAN = 3) 
                        AND pst_detail.THN_PELAYANAN        = 2020 
                        AND pst_detail.BUNDEL_PELAYANAN     = 4 
                        AND pst_detail.NO_URUT_PELAYANAN    = 20
                        AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
                        AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON
            ) AS BETUL,

            (SELECT COUNT(*) 
                FROM pst_detail 
                    WHERE pst_detail.KD_JNS_PELAYANAN       = 4 
                        AND pst_detail.THN_PELAYANAN        = 2020 
                        AND pst_detail.BUNDEL_PELAYANAN     = 4 
                        AND pst_detail.NO_URUT_PELAYANAN    = 20
                        AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
                        AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON
            ) AS BATAL,

            (
                -- op baru
                (SELECT COUNT(pst_detail.KD_JNS_PELAYANAN) 
                FROM pst_detail 
                    WHERE pst_detail.KD_JNS_PELAYANAN       = 1 
                        AND pst_detail.THN_PELAYANAN        = 2020 
                        AND pst_detail.BUNDEL_PELAYANAN     = 4 
                        AND pst_detail.NO_URUT_PELAYANAN    = 20
                        AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
                        AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON)
                +
                -- betul
                (SELECT COUNT(*)
                FROM pst_detail 
                    WHERE (pst_detail.KD_JNS_PELAYANAN      = 2 OR pst_detail.KD_JNS_PELAYANAN = 3) 
                        AND pst_detail.THN_PELAYANAN        = 2020 
                        AND pst_detail.BUNDEL_PELAYANAN     = 4 
                        AND pst_detail.NO_URUT_PELAYANAN    = 20
                        AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
                        AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON)
                +
                -- batal
                (SELECT COUNT(*) 
                FROM pst_detail 
                    WHERE pst_detail.KD_JNS_PELAYANAN       = 4 
                        AND pst_detail.THN_PELAYANAN        = 2020 
                        AND pst_detail.BUNDEL_PELAYANAN     = 4 
                        AND pst_detail.NO_URUT_PELAYANAN    = 20
                        AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
                        AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON)

            ) AS JUMLAH

        FROM pst_detail 

        INNER JOIN 
            ref_kecamatan 
                ON pst_detail.KD_KECAMATAN_PEMOHON    = ref_kecamatan.KD_KECAMATAN
        INNER JOIN 
            ref_kelurahan   
                ON ref_kecamatan.KD_KECAMATAN         = ref_kelurahan.KD_KECAMATAN

        WHERE pst_detail.THN_PELAYANAN          = 2020
            AND pst_detail.BUNDEL_PELAYANAN     = 4         
            AND pst_detail.NO_URUT_PELAYANAN    = 20
            AND ref_kelurahan.KD_KELURAHAN      = pst_detail.KD_KELURAHAN_PEMOHON   
            AND ref_kecamatan.KD_KECAMATAN      = pst_detail.KD_KECAMATAN_PEMOHON
