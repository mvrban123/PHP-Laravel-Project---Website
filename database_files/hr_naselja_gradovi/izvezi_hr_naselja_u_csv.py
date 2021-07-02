#!/usr/bin/env python
# coding: utf-8
# **Dataset from: https://www.posta.hr/preuzimanje-podataka-o-postanskim-uredima-6543/6543**

import pandas as pd

target_cols = [
    "BrojPu",
    "Naselje"
]

df_mjesta = pd.read_excel("./mjestaRh.xlsx", usecols=target_cols)

# df_mjesta

df_mjesta.to_csv("hr_naselja_air_2020.csv", index=False)

