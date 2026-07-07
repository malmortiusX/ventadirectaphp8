@extends('layouts.app')

@php
    $empresa = \App\Models\TblEmpresa::first();
@endphp

@section('content')
<div class="container-full vertical-align" id="mensaje-correcto" style="display: none;">
    <div class="row mb-0">
        <div class="col s12 center">
            <h2 class="pt-2 center my-0">¡Muy Bien!</h2>
            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" width="300" height="300">
                <title>7000947-ai</title>
                <defs>
                    <image  width="185" height="468" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALkAAAHUAQMAAABcfhsvAAAAAXNSR0IB2cksfwAAAAZQTFRF+JUg/3JdUzknNQAAAAJ0Uk5T/wDltzBKAAACnUlEQVR4nL3ZQc6lIAwA4BIWLDmCR+FosJtrcRSO4NKF0XEy8v7/FUgrBd1+CQXSilRwZ/UJ8KcF0Tcg2QasqgE7VMMHOMDU4QRoQKiOdUGsjnXBWh3rgg1qY12wQ22sCw6AyhovuOYLvgXlft2gqxCgMuEMxYQzFEEyFEEyFEE+gFfyD+I/WFqAt+sDOPoHcPQf8C1wJSSoTOsHbAtMC3QLVAkrVBbCAf8YHB82qOwJB+xjMAXsBOjHoPhwQGXfZeAfg8NwdsPyGGwBoRfMY9B8iASoxwB8SBT4ceAwrN2wjAOLYesGI4e7nr+yQQhKDrmeYSB4LpwkuIkQyvyRgpVDvMGMA82G1A1KDrls4Q3wXNhIcPMgl+2vjBODFcNBghkHGsE5ARQbAgXwBngEsR+cGBIJywtgEaz9YMSwkaDnwads1QsAXDho8NPgpMGNg4ULoR+sGCIJRgyJBC2GlQTFha0fgAtFgTwAz4SiDh6A+4Yi3UfAgiBMAIsgjoOUwcwDnNUCwAdFCUoM+KAoAbiAD4on4JmAz4Mn4LgQ+mFBECeARZAmgEGwjoONBC0GlNVT4CABuHAKwHMh9INDECfAgiC9AN83ChFsJBgx7CRoLhz9oLhwTgDAEMZBzODnQSLBcWHth4ULWz9YLuzj4KsnNQm+elJCCBQoOcRuADakfvAI1hfgd9N2Fvzu5grhIMGK4ewHgyGMB40hvgDpBiWHtRuADVs/eAT7C/BJRSeGk4RFDqEbLBtiNxg2pHGQU1FPhI0CxYZ9PACGYxz8/GKfCIECJ4dIwcKGNB4shnUcbBQYOezdoNlwjAeF4RwIgQAYALEV44aiom4oXuF3KhZfABl8A/DlJwO+uP9/1rK9kwE3ATPgrvMH/A1/ARaoDdLupt7MAAAAAElFTkSuQmCC"/>
                    <image  width="244" height="389" id="img2" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPQAAAGFAQMAAADw6ExtAAAAAXNSR0IB2cksfwAAAAZQTFRF/3Jd+JUgd1kKLAAAAAJ0Uk5TAP9bkSK1AAAC6UlEQVR4nO3aS3KsIBQGYFM96GEvwaWwNFkaS2EJDB1YcKNttwqcx/XHSioJs9SX4qD8PmjpuqXdfMe2fuQ9JZbvKTnOTUpsgZTYAvfZw/rHrdr91sHD5/yx8KsDM+X+eHqyS/flSIbV0/pHVuCW3s0tpbICfcqbPXjB70PNu3+1ie/+UOCjwvsC95rHzU3Nd6eoyrsBnHNXnvz/cg96EHwEfQI9Cp5Qt6A70N8TZM55EHwEfQI9gp5Qt4I70D3oQek94aPgE+gR9IS6Bd0J7kEPoK8T+DjrE+gR9CS5Bd2B7kEPoI+gPyew+v6i8gh6Qt0K7kD3oAfQR9AnjVdej18tgp5Qt6A70D3oAfQR9HmCq+sXpUfQ09VuQXdf7P56JxaIzxa+uY8/3Kdv4MOf/2o3f37axx/g/Rd6+OXuGzi9wNM5s0AQHX3B1jj3giP5vEDgHoAqH0A3tHca7y92OiBR5df9QvB0OiCTyumA6JwOyKjzAXRDeWjj/Vn3HR8QpZMBaORkQJzOyYAonQyI1gfQzcXeg04FpJVTAdE6FRCtUwHROhUQtQ+gG9Cl/qXxn3QvnF+tU/OrdSpfrZzKv/SNr5Wbk/76xjiATrDWyfv31MbJ54vSyedb1Dn6ia6nPLVxc9otGw+tkyy6Y6df6cwCyLdw9AsVs4BUeU/72MIN7RM//bBHPh6it/hAwq2f5wCjzq3/5wBLzv3+MAdU8h7xwP/+pfEBcc9PfwNn4/F5/iVnp/9z/nkX4hOF+Ef+8lquPy4f0gfQIFx/Xrh/OOH+ZoX7b8ff/6PwfJO22KzvL+QA/NPF9WVPuF2dusRXpo5w22RpuOGTR7htIq0XcG+vh2jj6hHuNulWT+Fhx3WlwGGXcaWA6/gCdu9lgXjgskC2IbwoEI5eFHCZ53PQ5e3IxS7wbITlfvXjCH3hxxHmw+uyGJZ8GGE5vOMh5mcn78BW/T2CWOXtEOrdb0Em+FXBk778w+7c/gPx029X4WHt1QAAAABJRU5ErkJggg=="/>
                    <image  width="50" height="193" id="img3" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAADBCAMAAAC65xM0AAAAAXNSR0IB2cksfwAAAmpQTFRFAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQJk2OgAAAM50Uk5TACACPy84Xi2NJLsa5xAS/wZr8Zroxt301B7KSsB1tKGszaL5mCaOVYR6snDfaApcNlRhSbo0KkEVbgzH+O0f5NrPoMXL+rAnppuDkYfcfHJnX4tTt0jjPgszOilmkhS+Q+vgntbJtVGpff17b2OBWK9NQgk3LCGP89uZ0MjD96tSf5DXd2lbToqzMOIj5tPewvKFK3hsRuGcE/sBzogHgnPu2LhXpcwW8KRQkzsFqP4Odu/q2QOdlke5Gek9wfU1o3EX0UDS/JQND8SxtmLNHCxNAAAENElEQVR4nL3a659OVRTA8acZt6kZC4MZBqEphNFoJhONRMYtIRMyLjGRXKJ5yKXkHia3IbeZxJQi0riEUulC9/qfOud5zjl77Xe/9ab9/vtZ+znn7LXXXvtJpf6H8YBZ5OSaSbv2ZtKho5l0yjOTBx8yk/wCq+gsXawkV6wi1bWbmRR2N5MePc2kqNgqeklvKymRPlbSV/pZycPS30oGyEAreURKjeJRkceMZJDIYCMZLDLESB4XGWokw0SG20SZiIywkScCUm4jIwPypI10CogxWVYEpNJG8gPylEkUBEJsiX9USKpM5OmQjDaRwpCYRGpMIJ6xkW4BqTaJseG8njWRkpCMM5G+IXnORMaHZIKJPB+SCovImRiSGguZFAqZbCGDMmSKhUzNkGkWUpMhL1jI9Ax50SC6ZITMMJDKLJlpILOyxJL5XsqS2QZSmyUvG8icLJnLxbyskFc4mR+ROk4WRGQsJwsjsoiTxREp46Q6IlxURaKIk1cjsoSToRFZykl9RF7jpHdElnEyMSK85suLhCzH5PWYrMDkjZjUY7IiJgsxKY4JTmM5K2OyipK6WMhqSsoTsoaSNxOylpJ1CXmLkp4JaYAinQhZD8l6RzZAssaRtyHZ6AitxiocSUOS7wgUnZ3YBEmuI/mQdHVkMyRbHHkHkncd2QrJe47UMpHnhGxjZLsiMMHsUGQnI9sUgSfEXYrsZkQJ2YNEO03eR6SDJnsR2acJO7vt16QRkQ80OUDEaC3g0u+nCRKpuXaS7N/BOAjJbEcOQZI6nJAjlKxOyDpKyppiwk8ipTE5ismxmHyISZLHj3MSf2foE8uME5E4yYPECeMUFqebI4I3/ezZOBynqWg5GYmPcJCGOMgZTJJseYKK5Mc3f0zJ2TjIYirS8ZGCf2DnksWC+08HY9FKhat4cFH9SUJoVan2yV6QDEgE7W+PckEKIfnUkfNMbHBC4LXDZ058zsSFZkfghn9GzWs+EukmJy62ILJHBfmCzWuzIqwvckkJeMrfqgR7xI06yFlELmvyJRFXLirBHnG5DvIVmtdyTdAjrlqpRNtVQs7pIKwE1yWoXCPCeymsjbRTi2FEXLmuyT5CvC+Sra4aLW4QsUi/FJbAZnjzQjchX2vRdBOISi/ILRLktke+AcJbKdJK5rXWC4Ke17ceIY2HO21afEeW8CovCOqET/cI6W5874k5JEi9R0hdPK/II6RHO9ITP5B5LfPILCCOeaKI1GylHiF3uWV3PUKS0UxPoEZosUfIJcCP9jf/k0d+BuKXZi2ukx7VDi8IuZROt2qxiVxLHveCoDp6qRaokjzvBUEdzXtaoNbRfS3GkYuJll+VuIs2x+FK/Iauiwr05sjKtd+VYNdr7ZUg6z2V+sO9xWqynQTL15WEtReQ+HNCDP6iN2t1fwcl9OF/Lv9r/8cWH/8BUun16wRVIncAAAAASUVORK5CYII="/>
                    <image  width="125" height="333" id="img4" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH0AAAFNAQMAAAAXQ/J/AAAAAXNSR0IB2cksfwAAAAZQTFRF/3Jd+JUgd1kKLAAAAAJ0Uk5TAP9bkSK1AAABpUlEQVR4nMXYQa6DIBQFUAwDhiyBpbA0WBpLYQkOHRj5/RWQ9yooFqgzThrevUltFULCxd1MwOXcBtbMOadTEC+wKagXLHALuAn9B4f2BLvyNxg4BIyRb0iyvtfp3B3WuJ4w7DGSZHuMJBn3EJMJDNKDwRCjKgwuB6HMFCCUoVkIZRgGnoVQV2Qh9JeXoCLoDLg8GFg2C7QAFrbPAi/AjNrfBlmA5RzUJbhqmOqBXgKrB14PogHIelD14L6HqQHQBsAaAG8AogfIBqB6gOsAUw+gQ4ANAT4ERHOY74D8AVj0zf4VGHQzDAL9BKb2gG/bW0C/ha0TsDKsv4FhPx8Q5kcgKsEOAXMCsjnoIYAfFBz+k28BWw9YGwFI3uWRZu4BtgeYBqB7AH7xeABbA1gbwIPXrPkeqBLYeyBLYO6BSECfAi8BOQVWgP2oh15C8uywngP5ABVhyYCM4E+6xCUc7SxBZT7AEFTGw5FdE5Q9QIzq10fUACFZPCzkGMLceL4Y5i4ByAdIUPYYYyMwUOXYVUfw4Y/1vsmaAINDfBKTAsfHvOT4wB8m2sjyUN37XQAAAABJRU5ErkJggg=="/>
                    <image  width="82" height="63" id="img5" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFIAAAA/AQMAAABJiA1cAAAAAXNSR0IB2cksfwAAAAZQTFRF/3JdRFlkreMQkwAAAAJ0Uk5TAP9bkSK1AAAA6UlEQVR4nFWSvQ0CMQyFHUUi5bV0WQQpqzAJdx1rsQErMALlFegetnDsh4vLp1zyXvwj4nGSjIW4b8SP5PFKXt/J2AMLPsEVR3AD0grYiMOg0/6g8yvpIPUL0rcC8Z72z/FmtzqT1YWsbmSFtCp2ya2KiblVta/LN/vbfvKL3fIMuym71bDFrVY7Oq1MzrPS/X1mpUc/MyuVOKpnotK4e9HUEk8vmt6zmFXSOGb1EEUbxN14j9JE0arxK0qc/THeoiXZn4HsT6f+LMTcn0Is1B8VfQSPHAUVDZSWoyA1R01KjqAIjaZcf8sXeUDRe5lkXNkAAAAASUVORK5CYII="/>
                </defs>
                <style>
                    .s0 { fill: #ebebeb }
                    .s1 { fill: #263238 }
                    .s2 { fill: #ffbf9d }
                    .s3 { fill: #ff9a6c }
                    .s4 { fill: #455a64 }
                    .s5 { fill: #000000 }
                    .s6 { opacity: .3;fill: #000000 }
                    .s7 { fill: #ff725e }
                    .s8 { fill: #ffffff }
                </style>
                <g id="Background Complete">
                    <g id="&lt;Group&gt;">
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m638.5 499.6c-96-0.9-182.8-1.7-245.8-2.3-31.4-0.1-56.8-0.3-74.5-0.3-8.7 0-15.5 0-20.2 0q-3.4 0.1-5.3 0.1-1.8 0-1.8 0.1 0 0 1.8 0.1 1.9 0 5.3 0.1c4.7 0.1 11.5 0.1 20.2 0.3 17.7 0 43.1 0.2 74.5 0.3 63 0.1 149.8 0.1 245.8 0.2 95.9 0 182.7 0.1 245.6 0.6 31.5 0.2 56.9 0.5 74.5 0.8 8.8 0.2 15.6 0.3 20.2 0.5 4.7 0.2 7.1 0.4 7.1 0.5 0 0.2-2.4 0.4-7.1 0.5-4.6 0.1-11.4 0.2-20.2 0.3-17.6 0.2-43.1 0.2-74.5 0.1-62.9-0.2-149.7-0.9-245.6-1.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m636.6 520.7c-94.7-15.4-180.4-29.4-242.4-39.4-31-4.9-56.1-8.9-73.5-11.6-8.7-1.3-15.4-2.3-20.1-3q-3.3-0.5-5.2-0.8-1.7-0.2-1.8-0.1 0 0 1.8 0.3 1.8 0.4 5.2 1c4.6 0.7 11.3 1.8 19.9 3.3 17.5 2.7 42.5 6.7 73.5 11.6 62.2 9.6 148 22.7 242.8 37.3 94.7 14.4 180.5 27.7 242.6 37.6 31 5 56.1 9.1 73.4 12.1 8.7 1.5 15.4 2.7 19.9 3.6 4.6 0.8 6.9 1.4 6.9 1.5 0 0.2-2.5 0-7.1-0.6-4.5-0.5-11.3-1.5-20-2.7-17.4-2.5-42.5-6.3-73.6-11.2-62.1-9.6-147.8-23.5-242.3-38.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m631.3 541.1c-91-29.6-173.3-56.5-233-76-29.8-9.5-54-17.3-70.7-22.7-8.3-2.6-14.8-4.6-19.3-6q-3.2-1-5-1.5-1.7-0.5-1.8-0.4 0 0 1.7 0.6 1.8 0.6 5 1.7c4.4 1.5 10.9 3.6 19.1 6.3 16.8 5.4 40.9 13.2 70.7 22.8 59.9 18.9 142.5 45 233.7 73.9 91.3 28.8 173.8 55 233.5 74.3 29.8 9.6 53.9 17.6 70.5 23.2 8.3 2.8 14.8 5 19.1 6.5 4.4 1.6 6.6 2.5 6.6 2.7-0.1 0.1-2.4-0.4-6.9-1.7-4.4-1.3-11-3.2-19.4-5.8-16.7-5.1-40.9-12.7-70.8-22.3-59.8-19-142.1-45.8-233-75.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m622.7 560.6c-85-43.3-162-82.4-217.7-110.7-27.9-14-50.5-25.4-66.2-33.3-7.8-3.8-13.9-6.8-18.1-8.9q-3-1.4-4.7-2.2-1.6-0.8-1.6-0.7 0 0 1.5 0.9 1.7 0.8 4.7 2.4c4.1 2.1 10.1 5.2 17.9 9.2 15.6 7.9 38.2 19.2 66.1 33.3 56 27.8 133.4 66.2 218.8 108.7 85.4 42.4 162.7 80.9 218.5 109.1 27.9 14.1 50.4 25.6 65.9 33.7 7.8 4 13.8 7.2 17.8 9.4 4.1 2.2 6.2 3.4 6.1 3.6-0.1 0.1-2.3-0.8-6.5-2.8-4.2-1.9-10.3-4.8-18.2-8.6-15.7-7.7-38.4-18.9-66.4-32.9-55.9-27.9-132.9-67-217.9-110.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m611.2 578.4c-77.1-55.6-146.8-105.9-197.3-142.4-25.3-18.1-45.8-32.7-60-42.8-7.1-5-12.6-8.9-16.4-11.6q-2.8-1.9-4.3-2.9-1.5-1-1.5-1-0.1 0.1 1.3 1.1 1.5 1.1 4.2 3.1c3.8 2.8 9.2 6.7 16.2 11.8 14.3 10.2 34.7 24.8 60 42.9 50.9 36.1 121.1 85.8 198.6 140.7 77.6 54.8 147.8 104.6 198.3 140.9 25.3 18.2 45.7 33 59.7 43.3 7 5.2 12.4 9.2 16.1 12 3.6 2.8 5.5 4.3 5.4 4.5-0.1 0.1-2.2-1.2-6-3.7-3.8-2.6-9.4-6.4-16.6-11.3-14.3-10-34.9-24.5-60.3-42.5-50.7-36.1-120.5-86.4-197.4-142.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m596.9 594.3c-67.2-66.5-128-126.8-172.1-170.5-22.1-21.6-40-39.2-52.4-51.4-6.2-6-11-10.6-14.4-13.9q-2.4-2.3-3.7-3.5-1.3-1.2-1.4-1.2 0 0.1 1.2 1.3 1.3 1.3 3.6 3.7c3.3 3.3 8.1 8 14.2 14.1 12.4 12.2 30.3 29.8 52.3 51.5 44.5 43.3 105.9 103 173.7 168.9 67.9 65.9 129.2 125.7 173.3 169.2 22.1 21.8 39.9 39.5 52.1 51.8 6.1 6.2 10.8 11 13.9 14.3 3.2 3.3 4.8 5.1 4.6 5.2-0.1 0.1-1.9-1.4-5.3-4.5-3.3-3.1-8.3-7.7-14.5-13.7-12.6-12-30.6-29.5-52.8-51.1-44.3-43.4-105.2-103.6-172.3-170.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m580.3 607.9c-55.8-75.9-106.2-144.7-142.8-194.5-18.3-24.7-33.2-44.8-43.5-58.7-5.2-6.8-9.2-12.2-12-15.9q-2-2.6-3.1-4-1.1-1.4-1.2-1.4 0 0 1 1.5 1 1.5 3 4.2c2.7 3.7 6.6 9.1 11.7 16 10.3 14 25.1 34 43.5 58.8 37 49.5 88.1 117.7 144.5 193.2 56.5 75.3 107.5 143.6 144.2 193.3 18.3 24.8 33 45 43.1 59 5 7 8.9 12.5 11.5 16.2 2.6 3.8 3.8 5.8 3.7 5.9-0.1 0.1-1.7-1.8-4.5-5.3-2.9-3.6-7-8.9-12.2-15.7-10.5-13.8-25.5-33.7-43.9-58.5-36.9-49.5-87.4-118.2-143-194.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m561.6 618.7c-42.8-83.4-81.6-158.9-109.6-213.7-14.2-27.2-25.7-49.3-33.6-64.6-4-7.6-7.1-13.4-9.3-17.5q-1.6-2.9-2.4-4.5-0.9-1.6-0.9-1.5-0.1 0 0.7 1.6 0.8 1.6 2.2 4.6c2.1 4.1 5.1 10 9 17.6 8 15.3 19.4 37.4 33.5 64.7 28.6 54.5 68.1 129.6 111.7 212.7 43.7 83 83.1 158.2 111.3 212.9 14.1 27.3 25.4 49.4 33.1 64.8 3.8 7.7 6.8 13.7 8.7 17.8 2 4 2.9 6.2 2.8 6.3-0.2 0.1-1.4-1.9-3.7-5.9-2.2-3.9-5.4-9.8-9.5-17.4-8.1-15.1-19.7-37.1-34-64.4-28.4-54.5-67.2-130-110-213.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m541.5 626.6c-28.8-88.9-54.8-169.5-73.7-227.8-9.6-29.1-17.3-52.6-22.7-69-2.7-8-4.9-14.3-6.3-18.7q-1.1-3.1-1.7-4.8-0.6-1.6-0.7-1.6 0 0 0.5 1.7 0.5 1.7 1.5 4.9c1.4 4.3 3.4 10.6 6 18.8 5.3 16.3 13.1 39.8 22.6 68.9 19.4 58.2 46.2 138.5 75.9 227.2 29.6 88.6 56.4 169 75.4 227.2 9.5 29.1 17.1 52.8 22.2 69.1 2.5 8.2 4.5 14.6 5.7 18.9 1.3 4.3 1.9 6.6 1.7 6.7-0.2 0-1.1-2.2-2.6-6.4-1.6-4.3-3.8-10.5-6.6-18.6-5.6-16.2-13.5-39.7-23.1-68.8-19.3-58.2-45.4-138.7-74.1-227.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m520.3 631.3c-14-92.2-26.7-175.7-35.9-236.2-4.7-30.2-8.6-54.6-11.2-71.6-1.4-8.4-2.5-14.9-3.2-19.4q-0.6-3.3-0.9-5.1-0.4-1.7-0.4-1.7-0.1 0 0.1 1.8 0.3 1.8 0.7 5c0.7 4.6 1.7 11.1 2.9 19.5 2.7 17 6.5 41.4 11.2 71.6 9.8 60.4 23.3 143.8 38.1 235.9 15 92.1 28.4 175.5 37.7 235.9 4.7 30.3 8.4 54.7 10.8 71.7 1.2 8.4 2.1 15 2.6 19.5 0.5 4.5 0.7 6.8 0.6 6.8-0.2 0.1-0.7-2.2-1.6-6.7-0.9-4.4-2-10.9-3.5-19.4-2.9-16.8-6.9-41.2-11.7-71.4-9.6-60.4-22.3-143.9-36.3-236.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m498.6 632.8c0.9-93.3 1.7-177.7 2.3-238.9 0.1-30.5 0.2-55.2 0.3-72.3-0.1-8.5-0.1-15.2-0.1-19.7q0-3.3-0.1-5.1 0-1.8-0.1-1.8 0 0-0.1 1.8 0 1.8-0.1 5.1c-0.1 4.5-0.1 11.2-0.2 19.7-0.1 17.1-0.3 41.8-0.4 72.3 0 61.2 0 145.6 0 238.9 0.1 93.2 0 177.6-0.4 238.7-0.2 30.6-0.5 55.3-0.9 72.4-0.1 8.5-0.3 15.2-0.5 19.7-0.2 4.5-0.3 6.8-0.5 6.8-0.2 0-0.3-2.3-0.5-6.8-0.1-4.5-0.2-11.2-0.3-19.7-0.2-17.1-0.2-41.8-0.1-72.4 0.1-61.1 0.8-145.5 1.7-238.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m477 630.9c15.8-92 30-175.2 40.4-235.6 5-30.1 9-54.5 11.9-71.4 1.3-8.4 2.3-15 3-19.5q0.5-3.2 0.8-5 0.2-1.8 0.1-1.8 0 0-0.3 1.7-0.4 1.8-1 5.1c-0.8 4.5-1.9 11-3.4 19.4-2.8 16.9-6.9 41.3-11.9 71.4-9.8 60.4-23.3 143.8-38.2 236-14.8 92.1-28.4 175.4-38.6 235.7-5 30.2-9.3 54.6-12.3 71.4-1.6 8.4-2.8 15-3.7 19.4-0.9 4.4-1.5 6.7-1.6 6.7-0.2-0.1 0-2.4 0.6-6.9 0.6-4.5 1.5-11 2.8-19.5 2.6-16.9 6.5-41.3 11.4-71.5 9.9-60.4 24.1-143.6 40-235.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m455.9 625.8c30.5-88.4 58.1-168.5 78.1-226.5 9.8-29 17.7-52.4 23.3-68.7 2.6-8.1 4.7-14.4 6.2-18.7q1-3.2 1.5-4.9 0.5-1.7 0.5-1.7-0.1 0-0.7 1.6-0.6 1.7-1.8 4.8c-1.5 4.3-3.6 10.6-6.4 18.7-5.6 16.2-13.6 39.7-23.4 68.7-19.5 58.2-46.3 138.4-75.9 227.2-29.6 88.6-56.5 168.9-76.3 226.9-9.9 29-18.1 52.4-23.8 68.6-2.9 8.1-5.2 14.3-6.8 18.5-1.6 4.3-2.5 6.4-2.7 6.4-0.1-0.1 0.5-2.4 1.8-6.7 1.3-4.3 3.3-10.6 5.9-18.8 5.3-16.3 13.1-39.8 22.9-68.9 19.5-58.1 47-138.1 77.6-226.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m435.9 617.5c44.4-82.6 84.6-157.5 113.8-211.7 14.4-27.1 26-49.1 34.1-64.3 4-7.6 7-13.5 9.2-17.6q1.5-2.9 2.3-4.6 0.8-1.5 0.7-1.6 0 0-0.9 1.5-0.9 1.6-2.5 4.5c-2.2 4.1-5.4 9.9-9.4 17.5-8.1 15.2-19.8 37.1-34.2 64.3-28.7 54.4-68.2 129.6-111.8 212.7-43.6 83-83.1 158.2-112.1 212.4-14.5 27.1-26.3 49-34.6 64.1-4.1 7.5-7.4 13.4-9.7 17.3-2.2 3.9-3.5 6-3.7 5.9-0.1-0.1 0.9-2.3 2.8-6.3 2-4.1 5-10.1 8.9-17.7 7.9-15.3 19.4-37.4 33.8-64.5 28.7-54.4 68.9-129.3 113.3-211.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m417.5 606.3c57.2-74.9 108.9-142.7 146.4-191.8 18.6-24.6 33.7-44.5 44.1-58.4 5.1-6.9 9.1-12.2 11.9-15.9q1.9-2.7 3-4.2 1-1.4 1-1.5-0.1 0-1.2 1.4-1.1 1.4-3.2 4c-2.8 3.7-6.9 9-12.1 15.8-10.5 13.8-25.5 33.7-44.1 58.3-37.1 49.5-88.1 117.7-144.6 193.1-56.4 75.5-107.6 143.7-144.9 192.8-18.7 24.6-33.9 44.5-44.5 58.1-5.3 6.8-9.5 12.1-12.3 15.6-2.9 3.5-4.5 5.3-4.6 5.2-0.1-0.1 1.2-2.1 3.8-5.8 2.6-3.7 6.5-9.1 11.6-16.1 10.2-13.9 25.2-33.9 43.7-58.6 37.1-49.3 88.8-117.2 146-192z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m401.1 592.4c68.5-65.3 130.5-124.5 175.4-167.3 22.3-21.5 40.3-38.9 52.8-51 6.2-6 11-10.7 14.3-14q2.4-2.3 3.7-3.6 1.2-1.3 1.2-1.3-0.1-0.1-1.4 1.1-1.3 1.3-3.8 3.5c-3.3 3.2-8.2 7.9-14.5 13.8-12.5 12.1-30.6 29.4-52.9 50.9-44.5 43.3-105.9 103-173.7 168.9-67.8 66-129.3 125.7-174 168.6-22.4 21.5-40.6 38.7-53.2 50.6-6.4 5.9-11.3 10.5-14.7 13.6-3.4 3-5.3 4.6-5.4 4.4-0.1-0.1 1.5-1.9 4.7-5.1 3.1-3.3 7.9-8.1 14-14.2 12.4-12.2 30.3-29.7 52.6-51.3 44.6-43.1 106.5-102.3 174.9-167.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m387.2 576.3c78.1-54.2 148.7-103.3 200-138.9 25.4-17.8 46-32.3 60.4-42.3 7-5 12.5-9 16.3-11.7q2.7-1.9 4.2-3 1.4-1.1 1.4-1.1 0-0.1-1.5 0.9-1.6 1-4.4 2.9c-3.8 2.6-9.3 6.5-16.5 11.4-14.3 10-34.9 24.5-60.4 42.3-50.9 36-121.1 85.7-198.7 140.6-77.5 54.9-147.7 104.6-198.8 140.2-25.5 17.8-46.3 32.2-60.7 42-7.2 4.9-12.8 8.6-16.7 11.1-3.8 2.5-5.9 3.8-6 3.7-0.1-0.2 1.8-1.7 5.5-4.5 3.6-2.7 9.1-6.7 16.1-11.8 14.1-10.2 34.7-24.8 60.1-42.7 51-35.9 121.6-85 199.7-139.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m376 558.2c85.9-41.7 163.5-79.4 219.9-106.8 28-13.7 50.7-24.9 66.4-32.6 7.8-3.9 13.8-6.9 18-9q3-1.6 4.7-2.4 1.5-0.9 1.5-0.9 0-0.1-1.6 0.7-1.7 0.8-4.8 2.2c-4.2 2-10.3 5-18.1 8.7-15.8 7.8-38.5 18.9-66.5 32.7-56.1 27.8-133.4 66.2-218.8 108.6-85.4 42.5-162.8 80.9-219 108.3-28.1 13.7-50.9 24.7-66.7 32.2-7.9 3.8-14 6.6-18.2 8.5-4.2 1.9-6.5 2.8-6.6 2.7 0-0.2 2-1.4 6.1-3.6 4.1-2.1 10.1-5.2 17.9-9.2 15.6-7.9 38.2-19.2 66.2-33.1 56.1-27.7 133.8-65.4 219.6-107z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m367.9 538.6c91.5-28 174.3-53.4 234.4-71.8 29.9-9.3 54.1-16.8 70.9-22.1 8.3-2.6 14.8-4.7 19.2-6.1q3.2-1.1 5-1.7 1.7-0.6 1.7-0.6 0-0.1-1.8 0.4-1.7 0.5-5 1.5c-4.5 1.3-11 3.3-19.3 5.8-16.8 5.3-41.1 12.8-71 22.1-59.8 18.9-142.4 45-233.7 73.8-91.2 28.9-173.8 55-233.7 73.5-30 9.2-54.3 16.6-71.1 21.6-8.4 2.5-14.9 4.4-19.4 5.6-4.5 1.2-6.8 1.8-6.9 1.6 0-0.1 2.2-1 6.6-2.5 4.3-1.5 10.8-3.7 19.1-6.4 16.7-5.5 40.9-13.2 70.8-22.6 59.9-18.7 142.7-44.2 234.2-72.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m363 518c94.9-13.7 180.9-26 243.1-35 31.1-4.6 56.2-8.4 73.6-11 8.7-1.3 15.4-2.4 20-3.1q3.4-0.6 5.2-0.9 1.8-0.3 1.8-0.4 0 0-1.8 0.2-1.9 0.2-5.2 0.7c-4.7 0.6-11.4 1.6-20.1 2.8-17.4 2.6-42.6 6.3-73.6 10.9-62.2 9.5-148 22.7-242.8 37.2-94.7 14.6-180.5 27.7-242.7 36.8-31.1 4.6-56.2 8.1-73.7 10.5-8.7 1.2-15.4 2-20 2.5-4.6 0.6-7.1 0.8-7.1 0.6 0-0.2 2.3-0.7 6.9-1.5 4.6-0.9 11.3-2 20-3.4 17.3-2.8 42.4-6.7 73.5-11.4 62.1-9.4 148-21.9 242.9-35.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m361.5 497c96 0.7 182.8 1.5 245.8 2 31.4 0.1 56.8 0.2 74.5 0.2 8.7 0 15.5 0 20.2 0q3.4-0.1 5.3-0.1 1.8-0.1 1.8-0.1 0-0.1-1.8-0.1-1.9-0.1-5.3-0.1c-4.7-0.1-11.5-0.2-20.2-0.3-17.7 0-43.1-0.1-74.5-0.3-63 0.1-149.8 0.1-245.8 0.2-95.9 0.1-182.7 0.1-245.6-0.3-31.5-0.2-56.9-0.4-74.5-0.7-8.8-0.2-15.6-0.4-20.2-0.5-4.7-0.2-7.1-0.4-7.1-0.5 0-0.2 2.4-0.4 7.1-0.5 4.6-0.1 11.4-0.3 20.2-0.3 17.6-0.2 43.1-0.3 74.5-0.2 62.9 0.1 149.7 0.7 245.6 1.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m363.4 475.9c94.7 15.3 180.4 29.1 242.5 39.1 31 4.9 56.1 8.8 73.5 11.5 8.6 1.3 15.4 2.3 20 3q3.4 0.5 5.2 0.7 1.8 0.2 1.8 0.2 0-0.1-1.7-0.4-1.9-0.3-5.2-0.9c-4.7-0.8-11.4-1.9-20-3.3-17.4-2.7-42.5-6.7-73.5-11.5-62.2-9.5-148-22.6-242.8-37-94.8-14.3-180.6-27.5-242.6-37.3-31.1-5-56.2-9.1-73.5-12-8.6-1.5-15.4-2.7-19.9-3.6-4.5-0.8-6.9-1.4-6.9-1.5 0-0.2 2.5 0 7.1 0.6 4.6 0.5 11.3 1.4 20 2.7 17.4 2.5 42.6 6.2 73.6 11 62.1 9.6 147.8 23.4 242.4 38.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m368.7 455.4c91 29.6 173.4 56.3 233.1 75.7 29.8 9.6 53.9 17.3 70.7 22.7 8.3 2.5 14.8 4.6 19.3 6q3.2 0.9 5 1.5 1.7 0.5 1.8 0.4 0-0.1-1.7-0.6-1.8-0.6-5-1.7c-4.4-1.5-10.9-3.6-19.2-6.3-16.7-5.4-40.9-13.1-70.7-22.7-59.9-18.9-142.5-44.9-233.8-73.6-91.2-28.7-173.9-54.8-233.5-74-29.9-9.7-54-17.5-70.6-23.1-8.3-2.8-14.8-5-19.1-6.6-4.4-1.5-6.6-2.4-6.6-2.6 0.1-0.2 2.5 0.4 6.9 1.7 4.5 1.2 11 3.2 19.4 5.7 16.8 5.1 41 12.7 70.9 22.2 59.7 19 142.1 45.7 233.1 75.3z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m377.2 436c85.1 43.1 162.1 82.1 217.9 110.4 27.9 14 50.5 25.3 66.2 33.2 7.8 3.8 13.9 6.8 18.1 8.8q3 1.5 4.7 2.3 1.6 0.7 1.6 0.7 0.1-0.1-1.5-0.9-1.6-0.9-4.6-2.4c-4.2-2.2-10.2-5.2-18-9.2-15.6-7.8-38.2-19.2-66.1-33.2-56.1-27.8-133.5-66.1-219-108.5-85.5-42.2-162.8-80.6-218.6-108.8-28-14-50.5-25.5-66-33.6-7.8-4-13.8-7.1-17.8-9.3-4-2.2-6.1-3.5-6.1-3.6 0.1-0.2 2.4 0.8 6.6 2.7 4.1 1.9 10.3 4.8 18.1 8.6 15.8 7.7 38.5 18.8 66.5 32.8 55.9 27.9 133 66.8 218 110z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m388.7 418.1c77.1 55.5 146.9 105.8 197.5 142.2 25.3 18 45.8 32.6 60.1 42.8 7 4.9 12.6 8.8 16.4 11.5q2.7 1.9 4.3 2.9 1.4 1 1.5 1 0-0.1-1.4-1.1-1.5-1.1-4.2-3.1c-3.7-2.8-9.2-6.7-16.2-11.8-14.2-10.2-34.7-24.8-60-42.8-51-36-121.2-85.6-198.8-140.5-77.7-54.7-147.9-104.4-198.5-140.7-25.3-18.1-45.7-32.8-59.8-43.1-7-5.2-12.4-9.2-16-12-3.7-2.8-5.5-4.3-5.4-4.5 0.1-0.1 2.1 1.1 6 3.7 3.8 2.5 9.4 6.3 16.5 11.3 14.4 9.9 35 24.4 60.4 42.4 50.8 36.1 120.6 86.3 197.6 141.8z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m403 402.2c67.3 66.5 128.2 126.7 172.3 170.3 22.1 21.6 40 39.2 52.5 51.3 6.2 6 11 10.7 14.4 13.9q2.4 2.3 3.7 3.6 1.3 1.2 1.4 1.1 0 0-1.2-1.3-1.3-1.3-3.6-3.7c-3.3-3.3-8.1-8-14.2-14.1-12.4-12.2-30.3-29.7-52.4-51.4-44.6-43.2-106-102.8-174-168.7-67.9-65.8-129.3-125.5-173.5-169-22.1-21.7-39.9-39.4-52.1-51.7-6.1-6.2-10.8-11-14-14.3-3.1-3.3-4.7-5.1-4.6-5.2 0.1-0.1 2 1.5 5.4 4.5 3.3 3.1 8.2 7.7 14.5 13.7 12.6 12 30.6 29.4 52.8 51.1 44.4 43.2 105.4 103.4 172.6 169.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m419.6 388.6c55.8 75.9 106.4 144.5 143 194.3 18.4 24.7 33.3 44.7 43.6 58.6 5.2 6.9 9.2 12.2 12 15.9q2 2.6 3.1 4.1 1.1 1.4 1.2 1.4 0-0.1-1-1.5-1-1.5-3-4.2c-2.7-3.8-6.6-9.1-11.7-16.1-10.3-13.9-25.2-33.9-43.6-58.7-37.1-49.4-88.2-117.6-144.8-193-56.5-75.2-107.6-143.5-144.3-193.1-18.4-24.8-33.2-45-43.3-59-5-7-8.9-12.4-11.5-16.2-2.5-3.7-3.8-5.7-3.7-5.8 0.2-0.1 1.7 1.7 4.6 5.3 2.8 3.5 6.9 8.8 12.2 15.7 10.5 13.7 25.5 33.6 44 58.4 36.9 49.4 87.5 118.1 143.2 193.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m438.2 377.7c42.9 83.4 81.8 158.9 110 213.6 14.2 27.3 25.6 49.3 33.6 64.6 4 7.6 7.1 13.4 9.3 17.5q1.6 2.9 2.5 4.5 0.8 1.5 0.9 1.5 0 0-0.7-1.6-0.8-1.6-2.3-4.6c-2.1-4.1-5.1-10-9-17.6-8-15.3-19.4-37.4-33.6-64.6-28.7-54.5-68.3-129.6-112-212.6-43.7-83-83.3-158.2-111.5-212.7-14.2-27.3-25.5-49.5-33.2-64.8-3.9-7.7-6.8-13.7-8.8-17.8-1.9-4.1-2.9-6.3-2.7-6.3 0.2-0.1 1.4 1.9 3.6 5.9 2.3 3.9 5.5 9.8 9.6 17.3 8.1 15.2 19.8 37.2 34 64.4 28.5 54.5 67.5 129.9 110.3 213.3z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m458.3 369.8c28.9 89 55.1 169.4 74.1 227.8 9.6 29 17.3 52.6 22.7 68.9 2.8 8.1 4.9 14.3 6.4 18.7q1.1 3.1 1.7 4.8 0.6 1.7 0.6 1.7 0.1-0.1-0.4-1.7-0.5-1.8-1.5-4.9c-1.4-4.4-3.4-10.7-6.1-18.8-5.3-16.4-13.1-39.9-22.7-69-19.5-58.1-46.4-138.4-76.1-227-29.8-88.7-56.7-168.9-75.8-227.2-9.5-29.1-17.1-52.7-22.2-69-2.6-8.2-4.6-14.6-5.8-18.9-1.3-4.3-1.9-6.6-1.7-6.7 0.2 0 1.1 2.2 2.7 6.4 1.5 4.2 3.7 10.5 6.5 18.6 5.7 16.2 13.6 39.7 23.3 68.8 19.3 58.1 45.5 138.6 74.3 227.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m479.5 365.1c14.2 92.2 27 175.7 36.2 236.2 4.8 30.2 8.7 54.6 11.4 71.6 1.4 8.4 2.4 14.9 3.2 19.4q0.6 3.2 0.9 5 0.3 1.7 0.4 1.7 0 0-0.2-1.7-0.2-1.8-0.7-5.1c-0.7-4.5-1.6-11-2.9-19.4-2.7-17-6.5-41.4-11.3-71.6-9.8-60.4-23.4-143.8-38.4-235.9-15.1-92.1-28.6-175.4-38-235.9-4.7-30.2-8.4-54.7-10.8-71.6-1.3-8.4-2.2-15-2.7-19.5-0.5-4.5-0.7-6.8-0.6-6.9 0.2 0 0.7 2.3 1.6 6.8 0.9 4.4 2 10.9 3.5 19.3 2.9 16.9 7 41.3 11.8 71.5 9.7 60.4 22.6 143.9 36.6 236.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m501.2 363.6c-0.8 93.3-1.4 177.7-1.9 238.9-0.1 30.5-0.2 55.2-0.2 72.3 0 8.5 0 15.2 0 19.7q0.1 3.3 0.1 5.1 0.1 1.8 0.1 1.8 0.1 0 0.1-1.8 0.1-1.8 0.2-5.1c0-4.5 0.1-11.2 0.2-19.7 0-17.1 0.1-41.8 0.2-72.3 0-61.2-0.1-145.6-0.3-238.9-0.2-93.2-0.2-177.6 0.2-238.7 0.1-30.6 0.4-55.3 0.7-72.4 0.1-8.5 0.3-15.2 0.5-19.7 0.1-4.5 0.3-6.8 0.5-6.8 0.2 0 0.3 2.3 0.5 6.8 0.1 4.5 0.2 11.2 0.3 19.7 0.2 17.1 0.3 41.8 0.3 72.4-0.1 61.1-0.7 145.5-1.5 238.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m522.8 365.4c-15.6 92.1-29.8 175.3-40 235.7-5 30.1-9 54.5-11.8 71.5-1.3 8.4-2.4 14.9-3.1 19.4q-0.4 3.3-0.7 5.1-0.2 1.7-0.2 1.7 0.1 0 0.4-1.7 0.3-1.8 1-5c0.7-4.5 1.9-11 3.3-19.4 2.8-17 6.9-41.4 11.9-71.5 9.7-60.4 23-143.8 37.8-236 14.7-92.1 28.2-175.5 38.3-235.8 5-30.2 9.2-54.6 12.3-71.4 1.5-8.4 2.7-14.9 3.6-19.4 0.9-4.4 1.4-6.7 1.6-6.7 0.2 0.1 0 2.4-0.6 6.9-0.6 4.5-1.5 11-2.8 19.5-2.5 16.9-6.4 41.3-11.3 71.5-9.8 60.4-23.9 143.7-39.7 235.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m543.9 370.5c-30.3 88.5-57.8 168.6-77.7 226.6-9.8 29-17.7 52.5-23.2 68.8-2.7 8.1-4.8 14.4-6.2 18.7q-1 3.2-1.6 4.9-0.5 1.7-0.4 1.7 0 0 0.7-1.6 0.6-1.7 1.7-4.8c1.5-4.4 3.7-10.6 6.5-18.7 5.5-16.3 13.4-39.8 23.2-68.7 19.4-58.3 46.1-138.6 75.7-227.3 29.4-88.7 56.2-169 75.9-227 9.9-29 18-52.5 23.8-68.7 2.8-8 5.1-14.3 6.7-18.5 1.6-4.2 2.5-6.4 2.7-6.4 0.1 0.1-0.5 2.4-1.7 6.7-1.3 4.3-3.3 10.7-6 18.8-5.2 16.3-13 39.9-22.7 68.9-19.5 58.1-46.9 138.2-77.4 226.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m563.9 378.8c-44.3 82.7-84.4 157.6-113.4 211.9-14.4 27.1-26 49.1-34.1 64.3-3.9 7.6-7 13.5-9.1 17.6q-1.5 3-2.4 4.6-0.7 1.6-0.7 1.6 0.1 0 0.9-1.5 0.9-1.6 2.5-4.5c2.2-4.1 5.4-9.9 9.5-17.4 8-15.3 19.7-37.3 34.1-64.4 28.5-54.5 67.9-129.7 111.4-212.8 43.5-83.2 83-158.4 111.9-212.6 14.4-27.2 26.2-49.1 34.5-64.2 4.1-7.5 7.4-13.3 9.6-17.3 2.3-3.9 3.5-5.9 3.7-5.9 0.2 0.1-0.8 2.3-2.8 6.4-2 4-5 10-8.9 17.7-7.8 15.3-19.3 37.3-33.6 64.5-28.7 54.4-68.7 129.3-113.1 212z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m582.3 390c-57 75-108.7 142.8-146.1 192-18.6 24.6-33.6 44.6-44 58.4-5.1 6.9-9.1 12.3-11.9 16q-1.9 2.7-3 4.2-1 1.4-1 1.4 0.1 0.1 1.2-1.3 1.1-1.5 3.2-4.1c2.8-3.6 6.9-9 12.1-15.8 10.4-13.8 25.5-33.7 44-58.3 37-49.6 88-117.9 144.4-193.3 56.3-75.5 107.3-143.8 144.6-193 18.6-24.6 33.8-44.5 44.4-58.1 5.3-6.8 9.5-12.1 12.3-15.7 2.9-3.5 4.5-5.3 4.6-5.2 0.1 0.1-1.1 2.1-3.8 5.8-2.6 3.7-6.5 9.2-11.6 16.1-10.2 14-25.1 34-43.6 58.7-37.1 49.4-88.7 117.3-145.8 192.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m598.7 403.8c-68.3 65.5-130.2 124.7-175.1 167.6-22.2 21.5-40.3 39-52.8 51.1-6.1 6-10.9 10.7-14.2 13.9q-2.4 2.4-3.7 3.7-1.2 1.3-1.2 1.3 0.1 0.1 1.4-1.1 1.3-1.3 3.8-3.6c3.3-3.2 8.2-7.8 14.4-13.7 12.6-12.1 30.6-29.5 52.9-51 44.4-43.4 105.7-103.1 173.5-169.2 67.7-66 129.1-125.7 173.8-168.7 22.3-21.5 40.5-38.8 53.1-50.7 6.4-5.9 11.3-10.5 14.7-13.6 3.4-3 5.2-4.6 5.4-4.5 0.1 0.1-1.5 1.9-4.7 5.2-3.2 3.3-7.9 8.1-14.1 14.2-12.3 12.2-30.2 29.7-52.4 51.3-44.5 43.2-106.4 102.5-174.8 167.8z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m612.7 420c-78 54.3-148.6 103.5-199.8 139.1-25.4 17.9-46 32.4-60.3 42.4-7.1 5-12.6 9-16.3 11.7q-2.8 1.9-4.2 3-1.5 1.1-1.4 1.2 0 0 1.5-1 1.5-1 4.3-2.9c3.8-2.7 9.4-6.5 16.5-11.4 14.3-10.1 34.9-24.5 60.4-42.4 50.8-36.1 121-85.8 198.5-140.8 77.4-55.1 147.6-104.8 198.6-140.5 25.5-17.8 46.2-32.2 60.6-42 7.2-4.9 12.9-8.7 16.7-11.2 3.8-2.5 5.9-3.8 6-3.6 0.1 0.1-1.8 1.6-5.4 4.4-3.7 2.7-9.1 6.7-16.2 11.8-14.1 10.3-34.6 24.9-60 42.8-50.9 36-121.5 85.2-199.5 139.4z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m623.9 438.1c-85.8 41.8-163.4 79.6-219.7 107-28 13.8-50.7 25-66.4 32.7-7.8 3.9-13.8 7-18 9.1q-3 1.5-4.7 2.4-1.5 0.8-1.5 0.8 0 0.1 1.6-0.6 1.7-0.8 4.8-2.3c4.2-2 10.3-4.9 18.1-8.7 15.8-7.8 38.4-18.9 66.5-32.7 56-27.9 133.3-66.4 218.7-109 85.3-42.6 162.6-81 218.8-108.5 28-13.8 50.8-24.8 66.6-32.3 7.9-3.8 14.1-6.7 18.3-8.5 4.2-1.9 6.4-2.9 6.5-2.7 0.1 0.1-2 1.4-6.1 3.5-4 2.2-10.1 5.3-17.9 9.3-15.5 7.9-38.1 19.3-66.2 33.1-56 27.8-133.6 65.7-219.4 107.4z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m632.1 457.6c-91.5 28.2-174.3 53.6-234.3 72.1-29.9 9.4-54.1 16.9-70.9 22.2-8.3 2.7-14.8 4.7-19.2 6.2q-3.3 1-5 1.6-1.7 0.6-1.7 0.7 0 0 1.7-0.5 1.8-0.5 5.1-1.4c4.5-1.4 11-3.4 19.3-5.9 16.8-5.3 41-12.8 70.9-22.1 59.9-19 142.4-45.2 233.6-74.2 91.2-29 173.8-55.2 233.7-73.7 29.9-9.3 54.2-16.8 71-21.8 8.4-2.4 15-4.3 19.4-5.6 4.5-1.2 6.8-1.8 6.9-1.6 0.1 0.2-2.2 1-6.6 2.6-4.3 1.5-10.8 3.7-19.1 6.4-16.7 5.5-40.8 13.2-70.8 22.6-59.8 18.8-142.6 44.4-234 72.4z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m637 478.2c-95 13.8-180.8 26.3-243.1 35.4-31 4.6-56.1 8.4-73.6 11-8.6 1.4-15.3 2.4-20 3.2q-3.3 0.5-5.2 0.9-1.7 0.3-1.7 0.3 0 0.1 1.8-0.1 1.8-0.3 5.2-0.7c4.6-0.7 11.4-1.6 20-2.9 17.5-2.6 42.6-6.3 73.6-11 62.2-9.6 148-22.8 242.7-37.5 94.7-14.7 180.5-27.9 242.7-37.1 31.1-4.6 56.3-8.2 73.7-10.5 8.7-1.2 15.5-2.1 20.1-2.6 4.6-0.6 7-0.8 7-0.6 0 0.2-2.3 0.7-6.9 1.5-4.5 0.9-11.3 2-19.9 3.5-17.4 2.8-42.5 6.7-73.6 11.5-62.1 9.4-148 22-242.8 35.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
                <g id="Desk">
                    <g id="&lt;Group&gt;">
                        <path id="&lt;Path&gt;" class="s1" d="m915.5 967.5c0 0.3-187.5 0.5-418.7 0.5-231.2 0-418.7-0.2-418.7-0.5 0-0.3 187.5-0.5 418.7-0.5 231.2 0 418.7 0.2 418.7 0.5z"/>
                    </g>
                </g>
                <g id="Character">
                    <g id="&lt;Group&gt;">
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s2" d="m712.9 857.3l-3.4 27.3c0 0-0.6 2.7-0.9 12.8-0.2 10.1-1.2 23.2-1.7 31.7-0.4 8.5-3.9 12.9-11.8 9.1-8-3.8-4.5-25.3-7.6-43.5-3.1-18.2 5.9-38.5 5.9-38.5z"/>
                                    <path id="&lt;Path&gt;" class="s2" d="m727.8 844.3c0 0 12.5 49.8 12.5 56-0.1 6.1-4 14.8-4 14.8 0 0-3.8 21.8-5.9 24.4-2 2.7-22.3 6.2-22.3 6.2l-13-7.5 5.2-11.3 11.3 1.8 2.6-9.3-7.3-10.8-6.3-52z"/>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s3" d="m714.8 882.7c0.1 0.1-0.2 1-0.7 2.6-0.4 1.6-1.2 4-1.9 6.9-1.6 5.9-3.3 14.2-4 23.4-0.2 2.3-0.3 4.6-0.4 6.8-0.1 2.1-0.1 4.3-0.4 6.3-0.5 4.1-2.5 7.7-5.3 9.3-2.8 1.7-5.7 1.1-7.2 0.2-0.7-0.5-1.2-1-1.5-1.4-0.2-0.4-0.3-0.6-0.3-0.6 0.1-0.1 0.6 0.8 2 1.6 1.4 0.7 4.1 1.2 6.6-0.4 2.5-1.5 4.3-4.9 4.8-8.8 0.2-2 0.2-4.1 0.3-6.3 0-2.2 0.1-4.4 0.3-6.8 0.8-9.3 2.6-17.6 4.4-23.5 0.8-2.9 1.7-5.2 2.3-6.8 0.6-1.6 1-2.5 1-2.5z"/>
                                    </g>
                                </g>
                                <path id="&lt;Path&gt;" class="s2" d="m693.4 856.2l-9-30.7c0 0 32.9-23.3 34.7-21.8 1.8 1.6 10.1 46 10.1 46l-16.9 18.1z"/>
                            </g>
                        </g>
                        <use id="&lt;Path&gt;" href="#img1" x="557" y="366"/>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m646.2 967.5h-125.2c-9.4-56.9 1.6-139.3 1.6-139.3l138.4-68c0 0 16.9 98-14.8 207.3z"/>
                                    <path id="&lt;Path&gt;" class="s1" d="m546.3 967.5h-171.9c-5.8-19.2-14.5-56.8-17.3-70.1-18.4-88.6 40.1-177.6 40.1-177.6l145.6 118.2c0 0-0.9 66.9 3.5 129.5z"/>
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <path id="&lt;Path&gt;" class="s1" d="m661.7 762.1c0.6-0.2-117.6 86.3-117.6 86.3l-158.4-107.5 29.3-55.9c0 0 81 34.5 123.1 25.9 42-8.7 88-46.2 88-46.2 10.4 22.5 29.2 72.5 35.6 97.4z"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <path id="&lt;Path&gt;" class="s4" d="m584.2 783q0.1 0-0.6 1-0.7 1.1-2 3.1-2.8 4.1-8 11.8c-7.1 10.3-17.3 25.3-30.2 44.2 1.6 16.5 2.2 35.7 3.4 56.9 1 21.4 0.4 42.2 1.7 67.5h-1.7c-1.2-25.2-0.5-46.1-1.5-67.4-1-21.4-1.6-40.6-3.1-57.1v-0.2l0.1-0.1c13.2-18.9 23.6-33.9 30.8-44.1q5.3-7.6 8.2-11.7 1.4-1.9 2.2-3 0.7-1 0.7-0.9z"/>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m576.5 162.9c15.8 12.5 24.8 33.1 23.3 53.1-0.8 9.8-3.4 20.9 2.9 28.3 6.3 7.4 18.6 7.2 24.6 14.8 7.1 8.9 1.2 22.2 3.7 33.3 2.4 10.4 13.4 18.1 24 16.7-12.5 10.2-27.7 16.8-43.7 19q-6.1-7.9-12.2-15.7c4.7 5.5 3.4 14.2-1 19.8-4.5 5.6-11.4 8.7-18.3 10.9-32.7 10.3-70.1 4.2-97.9-16"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m393.3 249c2.4-7.4 6.5-14.4 8.2-22 3.5-16.6-4.5-35.2 3.5-50 5.7-10.6 17.8-15.8 29.3-19.3 11.5-3.6 23.8-6.6 32.4-15 6.3-6.2 9.9-14.7 16.1-20.9 9-8.9 22.1-11.9 34.7-12.7 12.9-0.7 26.2 0.5 37.8 6.2 11.6 5.7 21.2 16.3 23.2 29.1 1.1 6.2 0.3 12.7 2.3 18.7 2.1 6.6 7.3 11.7 10.5 17.8 6.7 13 3 30.5-8.3 39.7l-88.5 114.2c-18.5 7-63.6-1.4-77.9-15.2-14.4-13.7-29.5-51.7-23.3-70.6z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s2" d="m586.7 292.1c-3.5 44-36.4 52.1-36.4 52.1 0-0.2 0.5 6.3 1.5 22.1l1.4 30.9c-1.2 12.2 10.2 44.9-0.1 49-46.5 18.5-91.6-42.1-101.1-56-0.6-0.9 0.3-2 1.3-1.6 3.8 1.5 14.4-6.2 14.5-6.2l-17.3-179.3c-0.7-7.9-6.3-20.7 1.5-22.1l79.5-26.8c25.8-4.7 45.5 25.9 49.1 51.9 4.1 28.8 7.9 64.1 6.1 86z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <path id="&lt;Path&gt;" class="s1" d="m567.3 245.1c0.3 3-1.9 5.7-4.9 6.1-3.1 0.4-5.8-1.7-6.2-4.6-0.3-2.9 1.9-5.6 5-6 3-0.4 5.8 1.6 6.1 4.5z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <path id="&lt;Path&gt;" class="s1" d="m512.8 248c0.3 2.9-1.9 5.6-5 6-3 0.4-5.8-1.6-6.1-4.5-0.3-3 1.9-5.7 5-6.1 3-0.4 5.8 1.7 6.1 4.6z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m577.1 227.6c-0.6 1.1-5.8-2.2-12.3-1.3-6.5 0.9-10.6 5.4-11.5 4.6-0.4-0.4 0.1-2.1 1.9-4.2 1.8-2 5-4.2 9-4.8 4.1-0.5 7.8 0.7 10 2.2 2.3 1.5 3.2 3.1 2.9 3.5z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m518.8 232.4c-0.7 1-5.8-2.7-12.8-2.4-7 0.2-12 4.2-12.8 3.3-0.3-0.4 0.4-2 2.6-3.9 2.1-1.8 5.7-3.6 10.1-3.8 4.3-0.1 8.1 1.5 10.3 3.1 2.2 1.7 3 3.3 2.6 3.7z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m540.7 273.5c-0.1-0.3 3.6-1.2 9.6-2.5 1.5-0.2 2.9-0.7 3.1-1.7 0.3-1.2-0.5-2.8-1.3-4.5q-2.6-5.4-5.5-11.3c-7.5-16.1-13.1-29.4-12.5-29.7 0.7-0.3 7.3 12.5 14.9 28.6q2.7 6 5.2 11.4c0.7 1.7 1.9 3.6 1.3 6-0.3 1.1-1.4 2.1-2.4 2.4-0.9 0.4-1.8 0.5-2.5 0.6-6.1 0.8-9.8 1.1-9.9 0.7z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <path id="&lt;Path&gt;" class="s3" d="m551.1 355.1c-43.2 7.4-60.2-22-60.2-22 30.3 15.2 59.4 11.1 59.4 11.1z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s3" d="m522.4 291c0.8-1.4 1.7-2.8 3.1-3.6 1.5-0.9 3.4-0.9 5.2-0.5 2.5 0.4 5 1.5 6.8 3.4 1.7 1.9 2.6 4.8 1.7 7.2-0.7 2.5-4.4 3.9-7 4.3-2.5 0.5-5.2-0.3-7.5-1.6-1.9-1-3.7-2.7-3.8-4.9 0-1.5 0.7-2.9 1.5-4.3z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m523.6 282.6c1-0.1 1.5 6.4 7.5 10.6 5.9 4.2 12.7 2.9 12.9 3.8 0.1 0.4-1.5 1.4-4.4 1.7-2.9 0.3-7.1-0.3-10.8-2.8-3.6-2.6-5.3-6.3-5.7-8.9-0.5-2.7 0.1-4.4 0.5-4.4z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <path id="&lt;Path&gt;" class="s1" d="m518.3 209c-0.5 1.7-6.5 1.3-13.5 2.7-7 1.3-12.5 3.8-13.5 2.4-0.5-0.7 0.4-2.3 2.5-4.1 2.2-1.7 5.7-3.5 9.9-4.3 4.2-0.8 8.1-0.4 10.7 0.5 2.7 0.8 4.1 2 3.9 2.8z"/>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <path id="&lt;Path&gt;" class="s1" d="m573.4 205.7c-1.1 1.4-5.9 0.4-11.6 0.8-5.7 0.2-10.4 1.7-11.6 0.3-0.6-0.6 0.1-2 2.1-3.5 2-1.4 5.3-2.7 9.2-2.9 4-0.2 7.4 0.7 9.5 2 2.1 1.2 2.9 2.6 2.4 3.3z"/>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m434.4 187.2c4-6.2 11.2-9.3 18.1-12 29.6-11.4 60.6-19.3 92.1-23.4 3.9 6.4 0.3 15.2-5.6 19.9-5.9 4.7-13.5 6.6-20.6 9.2-7.1 2.7-14.4 6.8-17.3 13.7-3.1 7.5-0.5 16.2-3.2 23.8-4.7 13-22.8 17.2-27.5 30.2-3.4 9.9 2.3 20.4 3.7 30.8 1.6 11.7-2.7 24.1-11.3 32.3-6.8 6.4-16.1 10.1-25.4 10.2q-3.2-56-6.5-112c-0.4-7.8-0.7-16.2 3.5-22.7z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m359.2 281.6c5.9-5.3 13.3-9.9 15.6-17.5 3.5-11-5.4-23.9 0.3-34 5.2-9.1 20.5-8.6 25.3-18 3.8-7.3-0.5-13.8 0.9-20.2 1.4-6.4 10.5-12 17.1-11.2l51 73.9c4.7 24.8 9.5 38 4.1 52.5-2.9 7.9-6.7 15.7-7.8 24.1-1.2 8.4 1 17.9 7.8 22.9-30.5 2.4-59-13.6-85.4-29q-14-8.2-28-16.4c-2.9-1.7-5.9-3.5-7.7-6.4-4.1-6.7 0.9-15.5 6.8-20.7z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s4" d="m399.9 316.9c3.9-1.1 8.6-3.2 12.7-7.2 4.1-4 7.4-10.1 8.2-17.2 0.3-3.6 0.1-7.5-1.1-11.2-1.1-3.8-3.3-7.3-5.6-11-2.3-3.6-4.8-7.4-6.1-12.1-1.2-4.5-1.3-10 1.9-14.3 1.5-2.1 3.9-3.6 6.2-4.5 2.4-1 4.8-1.7 7.1-2.6 2.3-1 4.4-2.3 5.7-4.3 1.4-1.9 1.9-4.4 1.8-7 0-5.1-2.3-10-3.4-15.5-0.6-2.8-0.8-5.7-0.1-8.6 0.8-2.9 2.7-5.5 5.1-7.2 4.9-3.5 11-3.9 16.3-4.4 5.4-0.4 10.6-1.5 15-4.4 4.3-2.7 7.9-6.5 10.1-10.9 2.3-4.4 3.1-9.3 3.9-14.1 0.8-4.8 1.4-9.6 3.1-14 1.7-4.4 4.5-8.3 7.7-11.3 6.4-6.1 14.5-9.2 22-9.8 7.5-0.5 14.2 1.5 19.4 4.3 5.2 2.8 9.1 6.3 11.8 9.4 2.7 3.1 4.4 5.9 5.4 7.8 0.5 1 0.8 1.8 1.1 2.3q0.3 0.7 0.3 0.8c-0.3 0.1-1.8-4.4-7.3-10.4-2.8-3-6.6-6.4-11.7-9-5.1-2.6-11.7-4.5-18.9-3.9-7.2 0.6-15 3.7-21.1 9.5-3 3-5.6 6.6-7.2 10.8-1.6 4.3-2.3 8.9-3 13.7-0.7 4.8-1.6 9.9-4 14.7-2.3 4.6-6.1 8.7-10.7 11.6-4.6 3-10.3 4.2-15.7 4.6-5.4 0.5-11.1 1-15.5 4.2-2.1 1.5-3.7 3.7-4.4 6.1-0.6 2.5-0.4 5.2 0.1 7.8 1 5.2 3.4 10.3 3.5 15.9 0 2.8-0.5 5.7-2.1 8-1.6 2.4-4.1 3.9-6.5 4.8-4.8 2-10 2.9-12.7 6.6-2.8 3.6-2.8 8.7-1.7 12.9 1.2 4.3 3.6 8.1 5.9 11.8 2.2 3.6 4.5 7.3 5.6 11.3 1.2 4 1.4 8 1 11.7-0.8 7.5-4.3 13.8-8.7 17.8-4.3 4.1-9.2 6.2-13.2 7.1-4.1 1-7.4 0.9-9.5 0.7-2.2-0.2-3.3-0.6-3.3-0.6 0-0.3 4.6 1.3 12.6-0.7z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m346 267.6c-0.3 1.7-0.1 4.4 1.5 7.2 0.9 1.3 2.1 2.7 3.8 3.7 1.6 0.9 3.8 1.5 6 1.4 4.6 0 9.8-2.8 12.3-8 1.3-2.6 1.9-5.6 1.9-8.7 0-3.2-0.9-6.4-2.1-9.6-1.3-3.2-2.9-6.4-4.4-9.9-1.5-3.4-2.7-7.2-2.8-11.3-0.1-4 0.8-8.5 4-11.7 3.2-3.3 8-4 12.2-4 4.3-0.2 8.7 0.3 12.6-1.3 3.9-1.5 6.1-5.6 6.5-9.9 0.6-4.3-0.5-8.7-1-13.1-0.7-4.4-0.5-9 0.7-13.3 2.4-8.4 8.1-15.5 15.1-19.5 7-4.2 15-4.5 21.9-4.9 6.9-0.3 13.4-0.7 18.9-2.8 5.5-1.9 10-5 13.4-8.1 3.5-3.1 5.9-6.4 7.6-9.2 3.4-5.7 4-9.4 4.2-9.4 0 0-0.4 3.8-3.6 9.7-1.6 2.9-4 6.4-7.5 9.6-3.4 3.3-8 6.5-13.7 8.6-5.6 2.3-12.3 2.7-19.3 3.1-6.8 0.4-14.5 0.8-21.1 4.8-6.6 3.9-11.9 10.6-14.2 18.6-1.1 4-1.4 8.3-0.7 12.6 0.6 4.3 1.7 8.8 1.1 13.5-0.3 2.4-0.9 4.7-2.2 6.8-1.3 2-3.3 3.6-5.4 4.5-4.5 1.8-9.1 1.3-13.3 1.4-4.1 0-8.3 0.7-11 3.5-2.8 2.6-3.7 6.7-3.6 10.4 0.1 7.8 4.5 14.2 6.9 20.8 1.3 3.3 2.2 6.7 2.2 10.1 0 3.3-0.8 6.5-2.2 9.3-2.8 5.6-8.5 8.5-13.4 8.4-2.4 0.1-4.7-0.6-6.5-1.7-1.8-1.1-3-2.6-3.9-4.1-1.6-3-1.7-5.8-1.3-7.6 0.4-1.7 1-2.5 1-2.5 0.1 0.1-0.4 0.9-0.6 2.6z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m668.8 285.3c0.4 1.3 0.6 3.5-0.3 6.2-0.8 2.5-2.8 5.7-6.6 7.1-3.8 1.4-8.9 0.5-12.5-3.1-1.7-1.8-2.8-4.5-3-7.2-0.2-2.7 0.3-5.5 1.1-8.2 1.7-5.5 4.7-10.9 4.2-17-0.4-6.1-3.5-12.3-8.7-16.4-2.6-2-5.7-3.6-9-4.6-3.3-1.1-6.8-1.3-10.4-1.5-3.6-0.2-7.3-0.3-10.9-1.2-3.6-0.8-7-2.8-9.2-5.8-2.1-3-3-6.5-3.2-9.9-0.3-3.4 0.2-6.7 0.9-9.9 1.3-6.2 3.1-11.9 2.8-17.4-0.2-5.5-2.2-10.4-5-14.1-2.7-3.8-6.3-6.2-9.4-8.3-3.2-2.1-5.9-4-7.9-5.8-2-1.9-3.2-3.7-3.8-5-0.3-0.6-0.5-1.1-0.6-1.4q-0.2-0.6-0.1-0.6c0.2-0.1 0.9 3 5 6.4 2 1.8 4.7 3.5 7.9 5.5 3.2 2 7 4.5 9.9 8.4 3 3.9 5.2 9 5.5 14.8 0.3 5.9-1.5 11.8-2.7 17.9-0.7 3-1.1 6.2-0.8 9.4 0.2 3.2 1 6.4 2.9 9 1.9 2.6 4.9 4.3 8.2 5.1 3.4 0.8 6.9 0.9 10.6 1.1 3.6 0.2 7.3 0.4 10.8 1.6 3.5 1 6.8 2.7 9.5 5 5.6 4.4 9 11.1 9.3 17.6 0.5 6.7-2.8 12.3-4.4 17.5-0.8 2.6-1.3 5.2-1.2 7.7 0.2 2.5 1.1 4.8 2.7 6.4 3.1 3.3 7.8 4.2 11.2 3.1 3.4-1.2 5.4-4.1 6.3-6.5 1.7-5-0.2-8 0.1-7.9 0 0 0.5 0.6 0.8 2z"/>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <use id="&lt;Path&gt;" href="#img2" x="409" y="358"/>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s1" d="m579 747q0 0 0.9-0.2 0.9-0.3 2.6-0.7 1.8-0.4 4.3-0.9 2.5-0.9 5.8-1.9c2.1-0.6 4.4-1.8 7-2.8 2.5-1 5.1-2.5 8-3.9 5.6-3.2 11.8-7.2 18-12.4 6.3-5.1 12.6-11.4 18.6-18.8 0.8-0.9 1.5-1.9 2.2-2.9q1.1-1.4 2.1-3 1.1-1.5 2-3.1 0.5-0.8 0.9-1.6l0.4-0.8 0.3-0.8c0.2-2.4-0.2-5-0.5-7.6q-0.7-3.9-1.6-7.8c-2.3-10.4-5.4-21.3-8.5-32.6-1.6-5.6-3.2-11.3-4.7-17.2-0.8-2.9-1.6-5.9-2.2-8.9-0.4-1.5-0.7-3-0.9-4.6-0.1-1.5-0.1-3.1-0.1-4.6 0.2-12.5 1.5-24.4 2.7-36v-0.1h0.1c5-19.8 9.4-38.7 10.1-55.9 0.1-4.3 0.1-8.5-0.5-12.5-0.5-4-1.7-7.8-2.7-11.5-2.2-7.2-4.8-13.8-7.4-19.6-5.2-11.7-10.5-20.6-14.2-26.6-1.8-3-3.3-5.3-4.4-6.8q-0.7-1.1-1.1-1.8-0.4-0.5-0.4-0.6 0 0 0.5 0.6 0.4 0.5 1.2 1.7c1.1 1.5 2.6 3.7 4.5 6.7 3.8 5.9 9.2 14.8 14.5 26.5 2.6 5.8 5.3 12.4 7.5 19.7 1.1 3.7 2.3 7.5 2.9 11.6 0.6 4 0.6 8.3 0.5 12.6-0.7 17.4-5.1 36.3-10.1 56.1h0.1c-1.3 11.5-2.6 23.6-2.8 35.9 0 1.5 0 3 0.2 4.5 0.2 1.5 0.4 3 0.8 4.5 0.6 3 1.4 5.9 2.2 8.8 1.5 5.9 3.1 11.6 4.7 17.3 3.1 11.2 6.1 22.1 8.5 32.6q0.9 4 1.5 7.9c0.4 2.6 0.8 5.1 0.5 7.8q-0.2 0.5-0.3 1l-0.5 0.9q-0.4 0.9-0.9 1.7-0.9 1.6-2 3.1-1.1 1.6-2.2 3c-0.7 1-1.4 2-2.2 2.9-6.1 7.5-12.5 13.7-18.8 18.9-6.3 5.1-12.5 9.1-18.2 12.3-2.9 1.4-5.6 2.9-8.1 3.9-2.6 1-4.9 2.1-7.1 2.7q-3.3 1-5.8 1.7c-1.7 0.4-3.2 0.7-4.4 1q-1.7 0.3-2.6 0.5-0.9 0.1-0.9 0.1z"/>
                            </g>
                            <g id="&lt;Group&gt;" style="opacity: .3">
                                <path id="&lt;Path&gt;" class="s5" d="m635.2 619.6c-0.4-9.2-3.9-21.2 1.6-45.7 5.9-26 10.5-43.1 10.3-65 5.2 23.8 0.3 48.3-2.7 72.5-3.7 29.8-1.8 60.2 5.5 89.3"/>
                            </g>
                            <use id="&lt;Path&gt;" style="opacity: .3" href="#img3" x="415" y="512"/>
                        </g>
                        <g id="&lt;Group&gt;">
                            <use id="&lt;Path&gt;" href="#img4" x="336" y="376"/>
                            <path id="&lt;Path&gt;" class="s2" d="m357.5 372.2c1.4 4.2-3.2 16.2-3.2 16.2l13.8 11.8 45.8 3.9c0 0-11.1-12.2-15-17.3-4-5.1-4.4-14.2 3.9-15.4 8.3-1.2 27.6 22.1 27.6 22.1 0 0 23.3 19.4 24 38.7 0.8 19.3 0 50 0 50l-39.8-6.8 3.7-25.9-46.3-14.9-24.7-19c0 0-6-23.6-6.1-26.9 0-11.4 8-22 8-22 0 0 6.1-1.2 8.3 5.5z"/>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m353.9 399.3c0.1-0.1 1.8 0.9 4.4 2.6 2.6 1.7 6.1 4.1 10 6.9q0.4 0.2 0.7 0.5h-0.6c4-2.7 8.5-2.9 11.4-2.3 1.5 0.3 2.6 0.7 3.3 1.1 0.8 0.3 1.1 0.6 1.1 0.7-0.1 0.1-1.7-0.7-4.5-1.1-2.8-0.4-7 0-10.7 2.5l-0.3 0.2-0.3-0.2q-0.3-0.3-0.7-0.6c-3.9-2.7-7.4-5.3-9.9-7.1-2.5-1.9-3.9-3.1-3.9-3.2z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m352.2 418.3c0.2 0.2-11.2 21.3-25.6 47.3-14.3 26-26.2 46.9-26.4 46.8-0.3-0.1 11.1-21.3 25.5-47.3 14.4-26 26.2-46.9 26.5-46.8z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m374.3 400.4c0.2 0-0.6 19.9-2 44.4-1.3 24.6-2.6 44.4-2.9 44.4-0.3 0 0.5-19.9 1.9-44.4 1.3-24.6 2.7-44.4 3-44.4z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m376.1 400.9c0.3 0 2.2 21.7 4.3 48.6 2.1 26.9 3.5 48.7 3.2 48.7-0.3 0-2.2-21.7-4.2-48.6-2.1-26.9-3.5-48.7-3.3-48.7z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s4" d="m146.6 781.4l123-283.4 144.7-35.7-120.7 302.8z"/>
                                    <path id="&lt;Path&gt;" class="s4" d="m210.5 812.7l-63.9-31.3 147-16.3 81.6 38.6z"/>
                                    <path id="&lt;Path&gt;" class="s6" d="m210.5 812.7l-63.9-31.3 147-16.3 81.6 38.6z"/>
                                    <path id="&lt;Path&gt;" class="s4" d="m414.3 462.3l3.3 13.3 22.4-0.7-64.8 328.8-81.6-38.6z"/>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m414.3 462.3q0 0.1-0.4 1.2-0.4 1.1-1.2 3.2c-1.1 2.9-2.8 7.1-4.9 12.4-4.2 10.8-10.4 26.4-18 45.7-15.3 38.5-36.5 91.6-59.8 150.4-12.9 32.2-25.1 62.8-36 90l-0.7-0.6c20.2-10.1 38.4-19.2 54.2-27.1l0.4-0.2 0.1 0.4c8.5 20.3 15.3 36.8 20 48.2 2.4 5.7 4.2 10.1 5.4 13.1q0.9 2.3 1.4 3.5 0.4 1.1 0.4 1.2 0 0-0.5-1.2-0.5-1.2-1.5-3.4c-1.3-3-3.2-7.4-5.6-13-4.8-11.4-11.7-27.8-20.3-48.1l0.5 0.2c-15.7 7.9-33.9 17.1-54 27.3l-1.1 0.5 0.4-1.1c10.9-27.3 23.1-57.9 35.9-90.1 23.5-58.7 44.7-111.8 60.1-150.3 7.8-19.2 14-34.7 18.4-45.5 2.1-5.4 3.8-9.5 5-12.4q0.9-2 1.3-3.2 0.5-1.1 0.5-1.1z"/>
                                    </g>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m417.6 475.6c0.2 0-15.2 58.8-34.5 131.2-19.3 72.5-35.1 131.1-35.4 131-0.3 0 15.1-58.8 34.4-131.2 19.3-72.5 35.2-131.1 35.5-131z"/>
                                    </g>
                                    <path id="&lt;Path&gt;" class="s6" d="m414.3 462.3l3.3 13.3-69.9 262.2-54.1 27.3z"/>
                                </g>
                            </g>
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m342.4 395.5c0.3 0.1-19.2 21.6-43.5 47.9-24.2 26.3-44 47.5-44.2 47.3-0.3-0.2 19.2-21.7 43.5-48 24.2-26.3 44-47.4 44.2-47.2z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s7" d="m101.1 713.9l123-242.7 144.7-30.5-120.8 259.2z"/>
                                    <path id="&lt;Path&gt;" class="s7" d="m165 740.7l-63.9-26.8 146.9-14 81.7 33z"/>
                                    <path id="&lt;Path&gt;" class="s6" d="m165 740.7l-63.9-26.8 146.9-14 81.7 33z"/>
                                    <path id="&lt;Path&gt;" class="s7" d="m368.8 440.7l3.2 11.3 22.5-0.6-64.8 281.5-81.7-33z"/>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m368.8 440.7q0 0-0.4 0.9-0.4 1-1.2 2.9c-1.2 2.5-2.8 6.1-5 10.8-4.3 9.4-10.6 22.9-18.3 39.6-15.5 33.5-37 79.7-60.7 130.7-12.4 26.5-24.1 51.8-34.7 74.5l-0.6-0.7c20.2-8.7 38.5-16.5 54.1-23.2l0.4-0.1 0.1 0.3c8.4 17.4 15.3 31.5 20 41.3 2.3 4.9 4.2 8.6 5.4 11.3q0.9 1.8 1.4 2.9 0.4 1 0.4 1 0 0-0.5-1-0.5-1-1.5-2.9c-1.3-2.5-3.2-6.3-5.6-11.1-4.8-9.8-11.7-23.8-20.3-41.2l0.5 0.2c-15.6 6.8-33.8 14.7-54.1 23.4l-1.1 0.5 0.5-1.1c10.6-22.7 22.3-48 34.7-74.5 23.8-51 45.3-97.1 61-130.6 7.8-16.6 14.1-30.1 18.6-39.5 2.2-4.6 3.9-8.2 5.1-10.7q0.8-1.8 1.3-2.8 0.5-0.9 0.5-0.9z"/>
                                    </g>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m372 452c0.3 0.1-15.1 50.4-34.4 112.4-19.3 62-35.2 112.2-35.4 112.2-0.3-0.1 15.1-50.5 34.4-112.5 19.3-62 35.2-112.2 35.4-112.1z"/>
                                    </g>
                                    <path id="&lt;Path&gt;" class="s6" d="m368.8 440.7l3.2 11.3-69.8 224.6-54.2 23.3z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m283.3 458.7q0 0 1.5-0.4 1.7-0.4 4.4-1c3.9-0.9 9.4-2.1 16.1-3.6 13.8-3 32.6-7 53.4-11.4q5.1-1.1 10-2.1l0.5-0.1 0.1 0.4q1.7 5.8 3.2 11.3l-0.5-0.3c8.2-0.2 15.7-0.4 22.5-0.5h0.5l-0.1 0.5c-2.3 9.6-4.2 17.5-5.5 23.2q-1 4-1.6 6.4-0.3 1-0.5 1.6-0.1 0.6-0.2 0.6 0 0 0.1-0.6 0.1-0.7 0.3-1.7 0.5-2.4 1.4-6.5c1.3-5.6 3-13.6 5.2-23.2l0.4 0.5c-6.8 0.2-14.3 0.4-22.4 0.7h-0.4l-0.1-0.4q-1.6-5.5-3.3-11.3l0.6 0.4q-4.9 1-10 2.1c-20.8 4.3-39.6 8.2-53.4 11.1-6.8 1.4-12.3 2.5-16.2 3.3q-2.8 0.5-4.4 0.8-1.6 0.3-1.6 0.2z"/>
                                </g>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m375.4 422.6c-0.2 0.1-1.5-2.7-5.1-5.9-1.9-1.6-4.3-3.2-7.3-4.2-1.5-0.6-3.2-0.8-4.9-1.3-0.9-0.3-1.8-0.8-2.5-1.5-0.8-0.7-1.2-1.7-1.4-2.7-0.3-2-0.1-3.8-0.4-5.5-0.2-1.7-0.6-3.3-1.1-4.8-0.6-1.5-1.2-2.9-2-4-0.8-1.2-1.9-1.8-3-2.2-1.1-0.4-2.2-0.4-3-0.1-0.8 0.4-1.3 1-1.6 1.6-0.5 1.2-0.5 2-0.7 2q0 0 0-0.5c0-0.4 0.1-1 0.3-1.6 0.3-0.7 0.8-1.5 1.8-2 0.9-0.5 2.2-0.4 3.4-0.1 1.2 0.3 2.6 1.1 3.5 2.4 0.9 1.2 1.6 2.6 2.2 4.1 0.6 1.6 1 3.3 1.2 5.1 0.3 1.8 0.1 3.7 0.5 5.4 0.1 0.8 0.4 1.6 1 2.2 0.6 0.6 1.3 0.9 2.1 1.2 1.6 0.5 3.3 0.8 4.9 1.4 3.1 1.1 5.6 2.8 7.4 4.5 1.9 1.7 3.1 3.4 3.8 4.6 0.7 1.2 0.9 1.9 0.9 1.9z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m351.4 366.9c0.1 0.1-0.9 1.4-2.2 3.5-1.4 2.2-2.9 5.4-4.1 9.1-2.3 7.5-2.4 14-2.8 13.9-0.1 0-0.2-1.6 0-4.2 0.2-2.6 0.7-6.1 1.8-10 1.2-3.8 2.9-7 4.4-9.2 1.6-2.1 2.8-3.2 2.9-3.1z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s1" d="m356.9 390.6c0.3 0.1-5 13.1-11.9 29.1-6.9 16-12.7 28.8-12.9 28.7-0.3-0.1 5.1-13.1 11.9-29.1 6.9-16 12.7-28.8 12.9-28.7z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s1" d="m361 394.1c0.3 0.1-2.7 11.5-6.6 25.6-3.9 14.1-7.3 25.4-7.5 25.4-0.3-0.1 2.6-11.6 6.5-25.7 3.9-14 7.3-25.4 7.6-25.3z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m425.4 405.8c0 0.3-8.7-0.3-19.4-1.4-10.6-1.1-19.2-2.2-19.2-2.5 0-0.3 8.7 0.4 19.3 1.4 10.7 1.1 19.3 2.2 19.3 2.5z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m418.3 387c0.3 0.2-1 2.5-3.4 4.5-2.5 2.1-4.9 2.9-5 2.7-0.2-0.3 2-1.5 4.3-3.5 2.3-1.9 3.9-3.8 4.1-3.7z"/>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <path id="&lt;Path&gt;" class="s1" d="m440 479.7q0 0 0.5 0.1 0.5 0 1.4 0.2 1.9 0.3 5.4 0.9c4.8 0.8 11.8 2.1 20.5 3.6l0.3 0.1v0.3c-2.7 24.4-7.6 63.5-16.1 107-3.6 18.5-7.6 36-11.6 51.9-3.7 15.9-7.2 30.2-11.9 41.7-2.4 5.7-5.2 10.8-9 14-3.6 3.4-7.4 5.5-10.6 6.8-3.2 1.4-5.9 1.9-7.7 2.1-1.8 0.2-2.8 0.2-2.8 0.2q0 0 0.7-0.1 0.7-0.1 2.1-0.3c1.8-0.3 4.4-0.9 7.5-2.2 3.2-1.4 6.8-3.6 10.4-6.9 3.7-3.2 6.4-8.2 8.7-13.9 4.6-11.4 8.1-25.7 11.7-41.7 3.9-15.8 7.9-33.3 11.5-51.8 8.5-43.5 13.5-82.6 16.4-106.9l0.3 0.3c-8.7-1.6-15.6-3-20.5-3.9q-3.4-0.7-5.4-1.1-0.8-0.1-1.4-0.3-0.4-0.1-0.4-0.1z"/>
                        </g>
                    </g>
                </g>
                <g id="Speech Bubble">
                    <g id="&lt;Group&gt;">
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <path id="&lt;Path&gt;" class="s8" d="m688.7 281.9l7.8-23.5c-7.9-11.8-12.7-25.8-13.3-41-1.6-43.6 32.5-80.3 76.2-81.9 43.6-1.6 80.3 32.5 81.9 76.1 1.6 43.7-32.5 80.3-76.1 81.9-18.3 0.7-35.3-4.9-49-14.7z"/>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <path id="&lt;Path&gt;" class="s1" d="m688.7 281.9c0 0 0.6-0.1 1.8-0.2q1.8-0.3 5.3-0.7c4.6-0.5 11.5-1.4 20.4-2.4l-0.2 0.4v-0.1c-0.1-0.1-0.1-0.2 0-0.3 0.1-0.1 0.3-0.1 0.3 0 8.5 5.9 20.7 12.2 36.4 14 3.9 0.5 7.9 0.7 12.2 0.5 4.1-0.3 8.5-0.5 12.9-1.6 8.8-1.7 17.8-5.1 26.2-10.5 8.5-5.3 16.3-12.5 22.5-21.4 6.2-8.9 10.8-19.4 13-30.8 4.4-22.8-2.3-49.1-19.8-67.7-8.9-9.4-19.8-16.7-31.7-20.7-11.8-4.1-24.2-5.2-35.9-3.7-11.8 1.4-22.7 5.7-32 11.6-9.3 6-17 13.6-22.7 21.9-5.7 8.4-9.5 17.4-11.6 26.2q-0.4 1.7-0.7 3.3c-0.3 1.1-0.5 2.2-0.6 3.3q-0.4 3.2-0.7 6.4c-0.1 4.2-0.3 8.3 0.1 12.3 1.4 15.7 7.2 28.1 12.8 36.5q0 0.1 0 0.3c-2.6 7.5-4.6 13.4-5.9 17.3q-1 3-1.6 4.6c-0.3 1-0.5 1.5-0.5 1.5q-0.1 0 0.4-1.5 0.5-1.5 1.4-4.5c1.3-4 3.3-9.9 5.7-17.6l0.1 0.2c-5.7-8.4-11.7-20.9-13.1-36.8-0.5-3.9-0.2-8.1-0.2-12.3q0.3-3.2 0.7-6.5c0.1-1.2 0.3-2.3 0.6-3.4q0.3-1.6 0.7-3.3c2.1-8.9 5.9-18 11.7-26.5 5.7-8.4 13.4-16.2 22.9-22.2 9.4-6 20.4-10.4 32.3-11.9 11.9-1.5 24.5-0.3 36.5 3.8 12 4 23.1 11.4 32.1 20.9 1.2 1.2 2.2 2.4 3.2 3.7l3 3.7 2.6 4c0.9 1.3 1.8 2.7 2.5 4.1q1.1 2.1 2.2 4.2c0.7 1.3 1.2 2.9 1.8 4.3 0.6 1.4 1.3 2.9 1.7 4.3q0.7 2.3 1.4 4.5c3.3 11.9 3.8 24.3 1.6 35.9-2.2 11.5-6.8 22.2-13.2 31.2-6.3 9-14.2 16.3-22.8 21.6-8.5 5.4-17.7 8.8-26.5 10.6-4.5 1-8.9 1.2-13.1 1.5-4.3 0.2-8.4 0-12.3-0.5-15.8-2-28.1-8.4-36.5-14.4l0.3-0.4c0.1 0.2 0.1 0.3 0 0.4q-0.1 0-0.1 0.1c-9 0.9-16 1.6-20.7 2.1q-3.4 0.4-5.2 0.6-1.8 0.1-1.7 0.1z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <use id="&lt;Path&gt;" href="#img5" x="725" y="183"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            <p class="pb-2 center my-0 subtitle-1">El pago ha sido exitoso.</p>
            <p class="pb-2 center my-0 subtitle-3">Pronto se verá reflejado en la plataforma.</p>
            <div class="row">
                <div class="col s0 m4 center"></div>
                <div class="col s12 m4">
                    <table>
                        <tr>
                            <td>Referencia:</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td>Aprobada</td>
                        </tr>
                    </table>
                </div>
                <div class="col s0 m4 center"></div>
            </div>
            <a class="mdc-button mdc-button--raised mb-1" href="{{ route('dashboard') }}">
                <span class="mdc-button__label">Ir al Dashboard</span>
            </a>
        </div>
    </div>
</div>
<div class="container-full vertical-align" id="mensaje-error" style="display: none;">
    <div class="row mb-0">
        <div class="col s12 center">
            <h2 class="pt-2 center my-0">¡Oh No!</h2>
            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" width="300" height="300">
                <title>7000947-ai</title>
                <defs>
                    <image  width="185" height="468" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALkAAAHUAQMAAABcfhsvAAAAAXNSR0IB2cksfwAAAAZQTFRF/3Jd+JUgd1kKLAAAAAJ0Uk5TAP9bkSK1AAACtklEQVR4nNXaS47cIBAGYCMvWPoIHIUcKzs4GkfhCFlmEYVM2+2OVI8UFEUrPdtPY2P4S21Dbd825u87B5GDUBk4fjGwt0yDaz+Yf2m/GUit0BDbT2ZY3LV8Y661N2ZcrnHXao15xi+oHNDz9QWNhNSYAT+AHHDibvIA8kkeQD5JbMyTnEDd/QTq7idQdz+Buns4oXBADOsCYlgXEFG5gBjvBcR4j38DsYhPyMNQEHgB6jDgyWJhb8wsSoCnVwI8vSw4AfCCiJC7YWvcgqihDgNeqaQFvIQS4CWMWsBLOA6BW1s95GEoEA411HnwXEz0gNIwDs96xmnQA0oDC04ClIYJyFD0UBZC4vKjB5QfFqIEKD96QPlhIagBBWsc7npGwZqA3AteD8UOKoB9AcDEseBEgIkzhFfZosTpASVuHJIEKIqGEG/IdlCmIYhQ7QBG8VgAMIoseD3AjBrCq55hRicARpEFNwF5GbzqGWV0BVQAaQHA8LIQRYAZNYRwA8zoOBwiwPCOgxcBhpeF8cr5C7kTZgqkdMKn1UG0g3ADm+p5kFM9D3Kqu8Hwh2LmFyR3wjYBpReSHmovRD2wqV4I429SE69Yhi9MC9+knAjddbBNQO6FpIcCIL4Bwg11HRh+angR5j81dhG668AtAINvcRE+7VscQhCh9MKhh9oL7C6WDN17UobwabtYSYLxzSoEUQ2oQMICyADGt3knNobLNOwi1GlwInRv824LABVIsof+445xCBIYnoMYHJD4BZAB7AugAHB2IB8U1nlIahg/KDQ4WgxvgDujqHLGwUuAKmccxo/YX+GF8J8fsfdDekKZh6iG2g1BDahyjjeAYauJ2INi0Jzi7AE3NxlCespKiBJkBth+r4Ig0Ol5AtVuGugLXVEk+2kPrv/34Np/D67D2XMNzv6+0B99kbx5hmBgBAAAAABJRU5ErkJggg=="/>
                    <image  width="244" height="389" id="img2" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPQAAAGFAQMAAADw6ExtAAAAAXNSR0IB2cksfwAAAAZQTFRF/3Jd+JUgd1kKLAAAAAJ0Uk5TAP9bkSK1AAAC5UlEQVR4nO3aTZKjIBQHcLtc9DJH8CgcDY7GUTgCSxcWrzvRREXeR+WvUzM9zS71q/AQniJC1z1KnzqxDKPsVET+JIqSOyIxAH0XuXqitPzom9XTq4W3VPMH0aYCf2jJbfa5Bf2xJX7xsvyoAvT0KuFxJdPeB6pLaFa/ll2A/sD7AMfq9wEaTHnlz5ZvRtu1nOTqdQ+KR6F3LJ5Az6CPik+gF9BJ8wB6BP01QO49z6CPik+gF9AJ9aB4BD0ZfWA8gz4qPoFeQCfUA+hR8QR6tvmN8xH0CfQCOmkeQI+gJ9Az6PMANt8/TD6BXhQn1APoEfQEegZ9tHjj9fZZJtAL6IR6AD2CnkDPoN8H+APwCfRysRPq4WKPF3vSnVngneP5L/fxh/tkcP/r/7W7X/9nfTT48OtsyT/c7/Mzv8D7My4sMFRHX7Cj8oJ3hksTbLC4B92973eWEugUFxJEce0LgM35BNF8/kLBJ8A5zifIaHMPuuM823y42NkESTZnE8TobIIYnU2AaHM2Ac5yD7oDfQCdS4CznEsQq3MJYnUuQazOJcBp7kF3F9eveZvXTUzFuf63Ojf+VufyD/XnHh53f1h9AN296c89Rn+xM6z6JKeH1dn5x+js/FfOcXSLbgDdve1BHH6rs7w8gEAXFiiaJzE9jI7uUAnrA81Hiw/v+ySnh80978XiPKtOBkc3SKT1t+pRXv9bXPr+cE9QzQfEs+4OdC950l1ig4vD/93/mAc5PUhJH1LSu8i35+P+lPJjlB9/8/NJ8KQ8H6Ly/ArK87eT54eizG/aEZvl/YUdwuf7l2c8dvIEHRbnrrB7ljavhzCd1Hx2CloPibavMHZygLB6qwu3R7JbAXanhL3UvHaAtPVGF4atHwNUJ8YPAapT0ocryHs/dFGsvB6DUHk1yMcD7cPOj+fV911QN69uYd28uoVH3vXh1PJNBY3wuwoa4bcVcMf5nVh99+rEwHkv/31uwib6F6s1aLEkGkSSAAAAAElFTkSuQmCC"/>
                    <image  width="125" height="333" id="img3" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH0AAAFNAQMAAAAXQ/J/AAAAAXNSR0IB2cksfwAAAAZQTFRF/3Jd+JUgd1kKLAAAAAJ0Uk5TAP9bkSK1AAABqElEQVR4nMXYzdGDIBAGYBkOHCmBUigNSqMUSvCYg+MmRv6WT4IkwOeNZ5R9N05QWRZ/cLALOgB2NGYAoFMQL0DXqBc88BQAWzKmB0A2J5qVv8HgIqiMfMOKi6C6J8S6JIczRtLeGSNJxh2EZCIH6cAUQTkI2d04Zs+BePDN0CL4ZlgVfCuhXVEE37+sggqgCwBlMLjZItAI9hpYFXiE9SaIKsgIj5ugqgDNQNqBtgNrB94Ooh1kB1DtAL8D6QC0A7AOwDuAGAGyA6gRAAOATAE6BdgU4FNANMLaB2R3sHdAjQdzB2A86G+A9If8X3oL6K+wDwL2Gbb/gTmrxdoHRCPYKWDugPwV9BTIXxQuQbXBPgW2ETDklWYdAXYEmA6gR0D+4fEF7B1g6wDffnepBNZ2sJcgm+C412ilq8NxJ9G6XodjjB5a15A8b/drIB/AbSj9AVWGc98i+UEcxHbXAsTu7JI144DmEKOaAsTsesmieghR3Tgm8+CDhN1DHyTsL5IcfJlHAImajf3aAAwnD7PqAG7WOD6zppu2FFd115gUOJ7ifYpP8QT7WcXSPcOofAAAAABJRU5ErkJggg=="/>
                    <image  width="63" height="63" id="img4" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD8AAAA/BAMAAAClcQ3sAAAAAXNSR0IB2cksfwAAABJQTFRFAAAARVlk/3Jd/3Jd/3Jd/3Jdjz8Q8wAAAAZ0Uk5TAP8FBAECYwDIngAAARtJREFUeJyFlVEagyAMg+mm7+YGHmFH8f6n2cd0QpIiPK0x/YFRSimDgdGHawQ2Ch0AQrD9B0CvBXTGaug0QB1VaYgAAy+lJXHUlH9SALA19Ukc9cqZFIAgbuVM4oiVmhQUqYEj2AybGLYE0PtPR4iBELAlOsIA4nCArtMBgkgAsk4HDBBUIBNAipAydkeRMTUoQi+KIey7IBzgp/rsmBqyKWI2x2ybuk9z2J89AQjitSfn2Rs+WclMK6YhlkHZ3ohjULVIAf3v7OZs2ZmJZA6FSrx6hghhBkGAw2fDueidFAeUnTpp0nLe3IsNUKSbhwK6nXLjbIBFXhQHHEEpIYCK4BQFFH32wg0F2geTp3UY1bGW4IfS7+L1nn8BvqxHlYEfWj4AAAAASUVORK5CYII="/>
                    <image width="22" height="17" id="img5" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAARCAYAAADZsVyDAAABWklEQVQ4T62UT06DQBTG51WjxIV/bkA3lsSFgJrQxgWeQI+AN9ATeAR7A4+gnqCYmJSFkS7bbuQILrWVeb43QIoERFveBoYZfu+bb94bEBSG4+piNnNR4CENdUShg8B3ngNoPdEj0rY3Hka+r779JaBjd28J5AmBu3U/gBA+ZXqcvA77tWuN41NXSKmzUl6sVCOamI7LAJQggrX1y/HLs1+VgNZUBydFGZ8j4lVpAoA+qb+uSF63qWTesHseorwp7oTtmYTBWZHyq+KylMmZ/NxBGfzfYKWeLJJxfJ8/cCjYshSY4QcnPXP+hYM8vLWptceBH/H80uAFXIYLy2A0DYfWymAG7B91L4REsiWJTPVKijNYx3IGVC2uUpp63QiYrwT5+fGWWhBR+bUbAStLbOeO2tbj92kYQGPgvOqtHW2vMbBSbXWpQtBsVLFqnLTtG/U4qxDuSr71vgHXuInSmcE1cQAAAABJRU5ErkJggg=="/>
                </defs>
                <style>
                    .s0 { fill: #ebebeb }
                    .s1 { fill: #263238 }
                    .s2 { fill: #ffbf9d }
                    .s3 { fill: #ff9a6c }
                    .s4 { fill: #455a64 }
                    .s5 { fill: #000000 }
                    .s6 { opacity: .3;fill: #000000 }
                    .s7 { fill: #ff725e }
                    .s8 { fill: #ffffff }
                </style>
                <g id="Background Complete">
                    <g id="&lt;Group&gt;">
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m638.5 499.6c-96-0.9-182.8-1.7-245.8-2.3-31.4-0.1-56.8-0.3-74.5-0.3-8.7 0-15.5 0-20.2 0q-3.4 0.1-5.3 0.1-1.8 0-1.8 0.1 0 0 1.8 0.1 1.9 0 5.3 0.1c4.7 0.1 11.5 0.1 20.2 0.3 17.7 0 43.1 0.2 74.5 0.3 63 0.1 149.8 0.1 245.8 0.2 95.9 0 182.7 0.1 245.6 0.6 31.5 0.2 56.9 0.5 74.5 0.8 8.8 0.2 15.6 0.3 20.2 0.5 4.7 0.2 7.1 0.4 7.1 0.5 0 0.2-2.4 0.4-7.1 0.5-4.6 0.1-11.4 0.2-20.2 0.3-17.6 0.2-43.1 0.2-74.5 0.1-62.9-0.2-149.7-0.9-245.6-1.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m636.6 520.7c-94.7-15.4-180.4-29.4-242.4-39.4-31-4.9-56.1-8.9-73.5-11.6-8.7-1.3-15.4-2.3-20.1-3q-3.3-0.5-5.2-0.8-1.7-0.2-1.8-0.1 0 0 1.8 0.3 1.8 0.4 5.2 1c4.6 0.7 11.3 1.8 19.9 3.3 17.5 2.7 42.5 6.7 73.5 11.6 62.2 9.6 148 22.7 242.8 37.3 94.7 14.4 180.5 27.7 242.6 37.6 31 5 56.1 9.1 73.4 12.1 8.7 1.5 15.4 2.7 19.9 3.6 4.6 0.8 6.9 1.4 6.9 1.5 0 0.2-2.5 0-7.1-0.6-4.5-0.5-11.3-1.5-20-2.7-17.4-2.5-42.5-6.3-73.6-11.2-62.1-9.6-147.8-23.5-242.3-38.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m631.3 541.1c-91-29.6-173.3-56.5-233-76-29.8-9.5-54-17.3-70.7-22.7-8.3-2.6-14.8-4.6-19.3-6q-3.2-1-5-1.5-1.7-0.5-1.8-0.4 0 0 1.7 0.6 1.8 0.6 5 1.7c4.4 1.5 10.9 3.6 19.1 6.3 16.8 5.4 40.9 13.2 70.7 22.8 59.9 18.9 142.5 45 233.7 73.9 91.3 28.8 173.8 55 233.5 74.3 29.8 9.6 53.9 17.6 70.5 23.2 8.3 2.8 14.8 5 19.1 6.5 4.4 1.6 6.6 2.5 6.6 2.7-0.1 0.1-2.4-0.4-6.9-1.7-4.4-1.3-11-3.2-19.4-5.8-16.7-5.1-40.9-12.7-70.8-22.3-59.8-19-142.1-45.8-233-75.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m622.7 560.6c-85-43.3-162-82.4-217.7-110.7-27.9-14-50.5-25.4-66.2-33.3-7.8-3.8-13.9-6.8-18.1-8.9q-3-1.4-4.7-2.2-1.6-0.8-1.6-0.7 0 0 1.5 0.9 1.7 0.8 4.7 2.4c4.1 2.1 10.1 5.2 17.9 9.2 15.6 7.9 38.2 19.2 66.1 33.3 56 27.8 133.4 66.2 218.8 108.7 85.4 42.4 162.7 80.9 218.5 109.1 27.9 14.1 50.4 25.6 65.9 33.7 7.8 4 13.8 7.2 17.8 9.4 4.1 2.2 6.2 3.4 6.1 3.6-0.1 0.1-2.3-0.8-6.5-2.8-4.2-1.9-10.3-4.8-18.2-8.6-15.7-7.7-38.4-18.9-66.4-32.9-55.9-27.9-132.9-67-217.9-110.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m611.2 578.4c-77.1-55.6-146.8-105.9-197.3-142.4-25.3-18.1-45.8-32.7-60-42.8-7.1-5-12.6-8.9-16.4-11.6q-2.8-1.9-4.3-2.9-1.5-1-1.5-1-0.1 0.1 1.3 1.1 1.5 1.1 4.2 3.1c3.8 2.8 9.2 6.7 16.2 11.8 14.3 10.2 34.7 24.8 60 42.9 50.9 36.1 121.1 85.8 198.6 140.7 77.6 54.8 147.8 104.6 198.3 140.9 25.3 18.2 45.7 33 59.7 43.3 7 5.2 12.4 9.2 16.1 12 3.6 2.8 5.5 4.3 5.4 4.5-0.1 0.1-2.2-1.2-6-3.7-3.8-2.6-9.4-6.4-16.6-11.3-14.3-10-34.9-24.5-60.3-42.5-50.7-36.1-120.5-86.4-197.4-142.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m596.9 594.3c-67.2-66.5-128-126.8-172.1-170.5-22.1-21.6-40-39.2-52.4-51.4-6.2-6-11-10.6-14.4-13.9q-2.4-2.3-3.7-3.5-1.3-1.2-1.4-1.2 0 0.1 1.2 1.3 1.3 1.3 3.6 3.7c3.3 3.3 8.1 8 14.2 14.1 12.4 12.2 30.3 29.8 52.3 51.5 44.5 43.3 105.9 103 173.7 168.9 67.9 65.9 129.2 125.7 173.3 169.2 22.1 21.8 39.9 39.5 52.1 51.8 6.1 6.2 10.8 11 13.9 14.3 3.2 3.3 4.8 5.1 4.6 5.2-0.1 0.1-1.9-1.4-5.3-4.5-3.3-3.1-8.3-7.7-14.5-13.7-12.6-12-30.6-29.5-52.8-51.1-44.3-43.4-105.2-103.6-172.3-170.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m580.3 607.9c-55.8-75.9-106.2-144.7-142.8-194.5-18.3-24.7-33.2-44.8-43.5-58.7-5.2-6.8-9.2-12.2-12-15.9q-2-2.6-3.1-4-1.1-1.4-1.2-1.4 0 0 1 1.5 1 1.5 3 4.2c2.7 3.7 6.6 9.1 11.7 16 10.3 14 25.1 34 43.5 58.8 37 49.5 88.1 117.7 144.5 193.2 56.5 75.3 107.5 143.6 144.2 193.3 18.3 24.8 33 45 43.1 59 5 7 8.9 12.5 11.5 16.2 2.6 3.8 3.8 5.8 3.7 5.9-0.1 0.1-1.7-1.8-4.5-5.3-2.9-3.6-7-8.9-12.2-15.7-10.5-13.8-25.5-33.7-43.9-58.5-36.9-49.5-87.4-118.2-143-194.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m561.6 618.7c-42.8-83.4-81.6-158.9-109.6-213.7-14.2-27.2-25.7-49.3-33.6-64.6-4-7.6-7.1-13.4-9.3-17.5q-1.6-2.9-2.4-4.5-0.9-1.6-0.9-1.5-0.1 0 0.7 1.6 0.8 1.6 2.2 4.6c2.1 4.1 5.1 10 9 17.6 8 15.3 19.4 37.4 33.5 64.7 28.6 54.5 68.1 129.6 111.7 212.7 43.7 83 83.1 158.2 111.3 212.9 14.1 27.3 25.4 49.4 33.1 64.8 3.8 7.7 6.8 13.7 8.7 17.8 2 4 2.9 6.2 2.8 6.3-0.2 0.1-1.4-1.9-3.7-5.9-2.2-3.9-5.4-9.8-9.5-17.4-8.1-15.1-19.7-37.1-34-64.4-28.4-54.5-67.2-130-110-213.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m541.5 626.6c-28.8-88.9-54.8-169.5-73.7-227.8-9.6-29.1-17.3-52.6-22.7-69-2.7-8-4.9-14.3-6.3-18.7q-1.1-3.1-1.7-4.8-0.6-1.6-0.7-1.6 0 0 0.5 1.7 0.5 1.7 1.5 4.9c1.4 4.3 3.4 10.6 6 18.8 5.3 16.3 13.1 39.8 22.6 68.9 19.4 58.2 46.2 138.5 75.9 227.2 29.6 88.6 56.4 169 75.4 227.2 9.5 29.1 17.1 52.8 22.2 69.1 2.5 8.2 4.5 14.6 5.7 18.9 1.3 4.3 1.9 6.6 1.7 6.7-0.2 0-1.1-2.2-2.6-6.4-1.6-4.3-3.8-10.5-6.6-18.6-5.6-16.2-13.5-39.7-23.1-68.8-19.3-58.2-45.4-138.7-74.1-227.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m520.3 631.3c-14-92.2-26.7-175.7-35.9-236.2-4.7-30.2-8.6-54.6-11.2-71.6-1.4-8.4-2.5-14.9-3.2-19.4q-0.6-3.3-0.9-5.1-0.4-1.7-0.4-1.7-0.1 0 0.1 1.8 0.3 1.8 0.7 5c0.7 4.6 1.7 11.1 2.9 19.5 2.7 17 6.5 41.4 11.2 71.6 9.8 60.4 23.3 143.8 38.1 235.9 15 92.1 28.4 175.5 37.7 235.9 4.7 30.3 8.4 54.7 10.8 71.7 1.2 8.4 2.1 15 2.6 19.5 0.5 4.5 0.7 6.8 0.6 6.8-0.2 0.1-0.7-2.2-1.6-6.7-0.9-4.4-2-10.9-3.5-19.4-2.9-16.8-6.9-41.2-11.7-71.4-9.6-60.4-22.3-143.9-36.3-236.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m498.6 632.8c0.9-93.3 1.7-177.7 2.3-238.9 0.1-30.5 0.2-55.2 0.3-72.3-0.1-8.5-0.1-15.2-0.1-19.7q0-3.3-0.1-5.1 0-1.8-0.1-1.8 0 0-0.1 1.8 0 1.8-0.1 5.1c-0.1 4.5-0.1 11.2-0.2 19.7-0.1 17.1-0.3 41.8-0.4 72.3 0 61.2 0 145.6 0 238.9 0.1 93.2 0 177.6-0.4 238.7-0.2 30.6-0.5 55.3-0.9 72.4-0.1 8.5-0.3 15.2-0.5 19.7-0.2 4.5-0.3 6.8-0.5 6.8-0.2 0-0.3-2.3-0.5-6.8-0.1-4.5-0.2-11.2-0.3-19.7-0.2-17.1-0.2-41.8-0.1-72.4 0.1-61.1 0.8-145.5 1.7-238.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m477 630.9c15.8-92 30-175.2 40.4-235.6 5-30.1 9-54.5 11.9-71.4 1.3-8.4 2.3-15 3-19.5q0.5-3.2 0.8-5 0.2-1.8 0.1-1.8 0 0-0.3 1.7-0.4 1.8-1 5.1c-0.8 4.5-1.9 11-3.4 19.4-2.8 16.9-6.9 41.3-11.9 71.4-9.8 60.4-23.3 143.8-38.2 236-14.8 92.1-28.4 175.4-38.6 235.7-5 30.2-9.3 54.6-12.3 71.4-1.6 8.4-2.8 15-3.7 19.4-0.9 4.4-1.5 6.7-1.6 6.7-0.2-0.1 0-2.4 0.6-6.9 0.6-4.5 1.5-11 2.8-19.5 2.6-16.9 6.5-41.3 11.4-71.5 9.9-60.4 24.1-143.6 40-235.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m455.9 625.8c30.5-88.4 58.1-168.5 78.1-226.5 9.8-29 17.7-52.4 23.3-68.7 2.6-8.1 4.7-14.4 6.2-18.7q1-3.2 1.5-4.9 0.5-1.7 0.5-1.7-0.1 0-0.7 1.6-0.6 1.7-1.8 4.8c-1.5 4.3-3.6 10.6-6.4 18.7-5.6 16.2-13.6 39.7-23.4 68.7-19.5 58.2-46.3 138.4-75.9 227.2-29.6 88.6-56.5 168.9-76.3 226.9-9.9 29-18.1 52.4-23.8 68.6-2.9 8.1-5.2 14.3-6.8 18.5-1.6 4.3-2.5 6.4-2.7 6.4-0.1-0.1 0.5-2.4 1.8-6.7 1.3-4.3 3.3-10.6 5.9-18.8 5.3-16.3 13.1-39.8 22.9-68.9 19.5-58.1 47-138.1 77.6-226.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m435.9 617.5c44.4-82.6 84.6-157.5 113.8-211.7 14.4-27.1 26-49.1 34.1-64.3 4-7.6 7-13.5 9.2-17.6q1.5-2.9 2.3-4.6 0.8-1.5 0.7-1.6 0 0-0.9 1.5-0.9 1.6-2.5 4.5c-2.2 4.1-5.4 9.9-9.4 17.5-8.1 15.2-19.8 37.1-34.2 64.3-28.7 54.4-68.2 129.6-111.8 212.7-43.6 83-83.1 158.2-112.1 212.4-14.5 27.1-26.3 49-34.6 64.1-4.1 7.5-7.4 13.4-9.7 17.3-2.2 3.9-3.5 6-3.7 5.9-0.1-0.1 0.9-2.3 2.8-6.3 2-4.1 5-10.1 8.9-17.7 7.9-15.3 19.4-37.4 33.8-64.5 28.7-54.4 68.9-129.3 113.3-211.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m417.5 606.3c57.2-74.9 108.9-142.7 146.4-191.8 18.6-24.6 33.7-44.5 44.1-58.4 5.1-6.9 9.1-12.2 11.9-15.9q1.9-2.7 3-4.2 1-1.4 1-1.5-0.1 0-1.2 1.4-1.1 1.4-3.2 4c-2.8 3.7-6.9 9-12.1 15.8-10.5 13.8-25.5 33.7-44.1 58.3-37.1 49.5-88.1 117.7-144.6 193.1-56.4 75.5-107.6 143.7-144.9 192.8-18.7 24.6-33.9 44.5-44.5 58.1-5.3 6.8-9.5 12.1-12.3 15.6-2.9 3.5-4.5 5.3-4.6 5.2-0.1-0.1 1.2-2.1 3.8-5.8 2.6-3.7 6.5-9.1 11.6-16.1 10.2-13.9 25.2-33.9 43.7-58.6 37.1-49.3 88.8-117.2 146-192z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m401.1 592.4c68.5-65.3 130.5-124.5 175.4-167.3 22.3-21.5 40.3-38.9 52.8-51 6.2-6 11-10.7 14.3-14q2.4-2.3 3.7-3.6 1.2-1.3 1.2-1.3-0.1-0.1-1.4 1.1-1.3 1.3-3.8 3.5c-3.3 3.2-8.2 7.9-14.5 13.8-12.5 12.1-30.6 29.4-52.9 50.9-44.5 43.3-105.9 103-173.7 168.9-67.8 66-129.3 125.7-174 168.6-22.4 21.5-40.6 38.7-53.2 50.6-6.4 5.9-11.3 10.5-14.7 13.6-3.4 3-5.3 4.6-5.4 4.4-0.1-0.1 1.5-1.9 4.7-5.1 3.1-3.3 7.9-8.1 14-14.2 12.4-12.2 30.3-29.7 52.6-51.3 44.6-43.1 106.5-102.3 174.9-167.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m387.2 576.3c78.1-54.2 148.7-103.3 200-138.9 25.4-17.8 46-32.3 60.4-42.3 7-5 12.5-9 16.3-11.7q2.7-1.9 4.2-3 1.4-1.1 1.4-1.1 0-0.1-1.5 0.9-1.6 1-4.4 2.9c-3.8 2.6-9.3 6.5-16.5 11.4-14.3 10-34.9 24.5-60.4 42.3-50.9 36-121.1 85.7-198.7 140.6-77.5 54.9-147.7 104.6-198.8 140.2-25.5 17.8-46.3 32.2-60.7 42-7.2 4.9-12.8 8.6-16.7 11.1-3.8 2.5-5.9 3.8-6 3.7-0.1-0.2 1.8-1.7 5.5-4.5 3.6-2.7 9.1-6.7 16.1-11.8 14.1-10.2 34.7-24.8 60.1-42.7 51-35.9 121.6-85 199.7-139.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m376 558.2c85.9-41.7 163.5-79.4 219.9-106.8 28-13.7 50.7-24.9 66.4-32.6 7.8-3.9 13.8-6.9 18-9q3-1.6 4.7-2.4 1.5-0.9 1.5-0.9 0-0.1-1.6 0.7-1.7 0.8-4.8 2.2c-4.2 2-10.3 5-18.1 8.7-15.8 7.8-38.5 18.9-66.5 32.7-56.1 27.8-133.4 66.2-218.8 108.6-85.4 42.5-162.8 80.9-219 108.3-28.1 13.7-50.9 24.7-66.7 32.2-7.9 3.8-14 6.6-18.2 8.5-4.2 1.9-6.5 2.8-6.6 2.7 0-0.2 2-1.4 6.1-3.6 4.1-2.1 10.1-5.2 17.9-9.2 15.6-7.9 38.2-19.2 66.2-33.1 56.1-27.7 133.8-65.4 219.6-107z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m367.9 538.6c91.5-28 174.3-53.4 234.4-71.8 29.9-9.3 54.1-16.8 70.9-22.1 8.3-2.6 14.8-4.7 19.2-6.1q3.2-1.1 5-1.7 1.7-0.6 1.7-0.6 0-0.1-1.8 0.4-1.7 0.5-5 1.5c-4.5 1.3-11 3.3-19.3 5.8-16.8 5.3-41.1 12.8-71 22.1-59.8 18.9-142.4 45-233.7 73.8-91.2 28.9-173.8 55-233.7 73.5-30 9.2-54.3 16.6-71.1 21.6-8.4 2.5-14.9 4.4-19.4 5.6-4.5 1.2-6.8 1.8-6.9 1.6 0-0.1 2.2-1 6.6-2.5 4.3-1.5 10.8-3.7 19.1-6.4 16.7-5.5 40.9-13.2 70.8-22.6 59.9-18.7 142.7-44.2 234.2-72.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m363 518c94.9-13.7 180.9-26 243.1-35 31.1-4.6 56.2-8.4 73.6-11 8.7-1.3 15.4-2.4 20-3.1q3.4-0.6 5.2-0.9 1.8-0.3 1.8-0.4 0 0-1.8 0.2-1.9 0.2-5.2 0.7c-4.7 0.6-11.4 1.6-20.1 2.8-17.4 2.6-42.6 6.3-73.6 10.9-62.2 9.5-148 22.7-242.8 37.2-94.7 14.6-180.5 27.7-242.7 36.8-31.1 4.6-56.2 8.1-73.7 10.5-8.7 1.2-15.4 2-20 2.5-4.6 0.6-7.1 0.8-7.1 0.6 0-0.2 2.3-0.7 6.9-1.5 4.6-0.9 11.3-2 20-3.4 17.3-2.8 42.4-6.7 73.5-11.4 62.1-9.4 148-21.9 242.9-35.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m361.5 497c96 0.7 182.8 1.5 245.8 2 31.4 0.1 56.8 0.2 74.5 0.2 8.7 0 15.5 0 20.2 0q3.4-0.1 5.3-0.1 1.8-0.1 1.8-0.1 0-0.1-1.8-0.1-1.9-0.1-5.3-0.1c-4.7-0.1-11.5-0.2-20.2-0.3-17.7 0-43.1-0.1-74.5-0.3-63 0.1-149.8 0.1-245.8 0.2-95.9 0.1-182.7 0.1-245.6-0.3-31.5-0.2-56.9-0.4-74.5-0.7-8.8-0.2-15.6-0.4-20.2-0.5-4.7-0.2-7.1-0.4-7.1-0.5 0-0.2 2.4-0.4 7.1-0.5 4.6-0.1 11.4-0.3 20.2-0.3 17.6-0.2 43.1-0.3 74.5-0.2 62.9 0.1 149.7 0.7 245.6 1.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m363.4 475.9c94.7 15.3 180.4 29.1 242.5 39.1 31 4.9 56.1 8.8 73.5 11.5 8.6 1.3 15.4 2.3 20 3q3.4 0.5 5.2 0.7 1.8 0.2 1.8 0.2 0-0.1-1.7-0.4-1.9-0.3-5.2-0.9c-4.7-0.8-11.4-1.9-20-3.3-17.4-2.7-42.5-6.7-73.5-11.5-62.2-9.5-148-22.6-242.8-37-94.8-14.3-180.6-27.5-242.6-37.3-31.1-5-56.2-9.1-73.5-12-8.6-1.5-15.4-2.7-19.9-3.6-4.5-0.8-6.9-1.4-6.9-1.5 0-0.2 2.5 0 7.1 0.6 4.6 0.5 11.3 1.4 20 2.7 17.4 2.5 42.6 6.2 73.6 11 62.1 9.6 147.8 23.4 242.4 38.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m368.7 455.4c91 29.6 173.4 56.3 233.1 75.7 29.8 9.6 53.9 17.3 70.7 22.7 8.3 2.5 14.8 4.6 19.3 6q3.2 0.9 5 1.5 1.7 0.5 1.8 0.4 0-0.1-1.7-0.6-1.8-0.6-5-1.7c-4.4-1.5-10.9-3.6-19.2-6.3-16.7-5.4-40.9-13.1-70.7-22.7-59.9-18.9-142.5-44.9-233.8-73.6-91.2-28.7-173.9-54.8-233.5-74-29.9-9.7-54-17.5-70.6-23.1-8.3-2.8-14.8-5-19.1-6.6-4.4-1.5-6.6-2.4-6.6-2.6 0.1-0.2 2.5 0.4 6.9 1.7 4.5 1.2 11 3.2 19.4 5.7 16.8 5.1 41 12.7 70.9 22.2 59.7 19 142.1 45.7 233.1 75.3z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m377.2 436c85.1 43.1 162.1 82.1 217.9 110.4 27.9 14 50.5 25.3 66.2 33.2 7.8 3.8 13.9 6.8 18.1 8.8q3 1.5 4.7 2.3 1.6 0.7 1.6 0.7 0.1-0.1-1.5-0.9-1.6-0.9-4.6-2.4c-4.2-2.2-10.2-5.2-18-9.2-15.6-7.8-38.2-19.2-66.1-33.2-56.1-27.8-133.5-66.1-219-108.5-85.5-42.2-162.8-80.6-218.6-108.8-28-14-50.5-25.5-66-33.6-7.8-4-13.8-7.1-17.8-9.3-4-2.2-6.1-3.5-6.1-3.6 0.1-0.2 2.4 0.8 6.6 2.7 4.1 1.9 10.3 4.8 18.1 8.6 15.8 7.7 38.5 18.8 66.5 32.8 55.9 27.9 133 66.8 218 110z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m388.7 418.1c77.1 55.5 146.9 105.8 197.5 142.2 25.3 18 45.8 32.6 60.1 42.8 7 4.9 12.6 8.8 16.4 11.5q2.7 1.9 4.3 2.9 1.4 1 1.5 1 0-0.1-1.4-1.1-1.5-1.1-4.2-3.1c-3.7-2.8-9.2-6.7-16.2-11.8-14.2-10.2-34.7-24.8-60-42.8-51-36-121.2-85.6-198.8-140.5-77.7-54.7-147.9-104.4-198.5-140.7-25.3-18.1-45.7-32.8-59.8-43.1-7-5.2-12.4-9.2-16-12-3.7-2.8-5.5-4.3-5.4-4.5 0.1-0.1 2.1 1.1 6 3.7 3.8 2.5 9.4 6.3 16.5 11.3 14.4 9.9 35 24.4 60.4 42.4 50.8 36.1 120.6 86.3 197.6 141.8z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m403 402.2c67.3 66.5 128.2 126.7 172.3 170.3 22.1 21.6 40 39.2 52.5 51.3 6.2 6 11 10.7 14.4 13.9q2.4 2.3 3.7 3.6 1.3 1.2 1.4 1.1 0 0-1.2-1.3-1.3-1.3-3.6-3.7c-3.3-3.3-8.1-8-14.2-14.1-12.4-12.2-30.3-29.7-52.4-51.4-44.6-43.2-106-102.8-174-168.7-67.9-65.8-129.3-125.5-173.5-169-22.1-21.7-39.9-39.4-52.1-51.7-6.1-6.2-10.8-11-14-14.3-3.1-3.3-4.7-5.1-4.6-5.2 0.1-0.1 2 1.5 5.4 4.5 3.3 3.1 8.2 7.7 14.5 13.7 12.6 12 30.6 29.4 52.8 51.1 44.4 43.2 105.4 103.4 172.6 169.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m419.6 388.6c55.8 75.9 106.4 144.5 143 194.3 18.4 24.7 33.3 44.7 43.6 58.6 5.2 6.9 9.2 12.2 12 15.9q2 2.6 3.1 4.1 1.1 1.4 1.2 1.4 0-0.1-1-1.5-1-1.5-3-4.2c-2.7-3.8-6.6-9.1-11.7-16.1-10.3-13.9-25.2-33.9-43.6-58.7-37.1-49.4-88.2-117.6-144.8-193-56.5-75.2-107.6-143.5-144.3-193.1-18.4-24.8-33.2-45-43.3-59-5-7-8.9-12.4-11.5-16.2-2.5-3.7-3.8-5.7-3.7-5.8 0.2-0.1 1.7 1.7 4.6 5.3 2.8 3.5 6.9 8.8 12.2 15.7 10.5 13.7 25.5 33.6 44 58.4 36.9 49.4 87.5 118.1 143.2 193.9z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m438.2 377.7c42.9 83.4 81.8 158.9 110 213.6 14.2 27.3 25.6 49.3 33.6 64.6 4 7.6 7.1 13.4 9.3 17.5q1.6 2.9 2.5 4.5 0.8 1.5 0.9 1.5 0 0-0.7-1.6-0.8-1.6-2.3-4.6c-2.1-4.1-5.1-10-9-17.6-8-15.3-19.4-37.4-33.6-64.6-28.7-54.5-68.3-129.6-112-212.6-43.7-83-83.3-158.2-111.5-212.7-14.2-27.3-25.5-49.5-33.2-64.8-3.9-7.7-6.8-13.7-8.8-17.8-1.9-4.1-2.9-6.3-2.7-6.3 0.2-0.1 1.4 1.9 3.6 5.9 2.3 3.9 5.5 9.8 9.6 17.3 8.1 15.2 19.8 37.2 34 64.4 28.5 54.5 67.5 129.9 110.3 213.3z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m458.3 369.8c28.9 89 55.1 169.4 74.1 227.8 9.6 29 17.3 52.6 22.7 68.9 2.8 8.1 4.9 14.3 6.4 18.7q1.1 3.1 1.7 4.8 0.6 1.7 0.6 1.7 0.1-0.1-0.4-1.7-0.5-1.8-1.5-4.9c-1.4-4.4-3.4-10.7-6.1-18.8-5.3-16.4-13.1-39.9-22.7-69-19.5-58.1-46.4-138.4-76.1-227-29.8-88.7-56.7-168.9-75.8-227.2-9.5-29.1-17.1-52.7-22.2-69-2.6-8.2-4.6-14.6-5.8-18.9-1.3-4.3-1.9-6.6-1.7-6.7 0.2 0 1.1 2.2 2.7 6.4 1.5 4.2 3.7 10.5 6.5 18.6 5.7 16.2 13.6 39.7 23.3 68.8 19.3 58.1 45.5 138.6 74.3 227.5z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m479.5 365.1c14.2 92.2 27 175.7 36.2 236.2 4.8 30.2 8.7 54.6 11.4 71.6 1.4 8.4 2.4 14.9 3.2 19.4q0.6 3.2 0.9 5 0.3 1.7 0.4 1.7 0 0-0.2-1.7-0.2-1.8-0.7-5.1c-0.7-4.5-1.6-11-2.9-19.4-2.7-17-6.5-41.4-11.3-71.6-9.8-60.4-23.4-143.8-38.4-235.9-15.1-92.1-28.6-175.4-38-235.9-4.7-30.2-8.4-54.7-10.8-71.6-1.3-8.4-2.2-15-2.7-19.5-0.5-4.5-0.7-6.8-0.6-6.9 0.2 0 0.7 2.3 1.6 6.8 0.9 4.4 2 10.9 3.5 19.3 2.9 16.9 7 41.3 11.8 71.5 9.7 60.4 22.6 143.9 36.6 236.1z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m501.2 363.6c-0.8 93.3-1.4 177.7-1.9 238.9-0.1 30.5-0.2 55.2-0.2 72.3 0 8.5 0 15.2 0 19.7q0.1 3.3 0.1 5.1 0.1 1.8 0.1 1.8 0.1 0 0.1-1.8 0.1-1.8 0.2-5.1c0-4.5 0.1-11.2 0.2-19.7 0-17.1 0.1-41.8 0.2-72.3 0-61.2-0.1-145.6-0.3-238.9-0.2-93.2-0.2-177.6 0.2-238.7 0.1-30.6 0.4-55.3 0.7-72.4 0.1-8.5 0.3-15.2 0.5-19.7 0.1-4.5 0.3-6.8 0.5-6.8 0.2 0 0.3 2.3 0.5 6.8 0.1 4.5 0.2 11.2 0.3 19.7 0.2 17.1 0.3 41.8 0.3 72.4-0.1 61.1-0.7 145.5-1.5 238.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m522.8 365.4c-15.6 92.1-29.8 175.3-40 235.7-5 30.1-9 54.5-11.8 71.5-1.3 8.4-2.4 14.9-3.1 19.4q-0.4 3.3-0.7 5.1-0.2 1.7-0.2 1.7 0.1 0 0.4-1.7 0.3-1.8 1-5c0.7-4.5 1.9-11 3.3-19.4 2.8-17 6.9-41.4 11.9-71.5 9.7-60.4 23-143.8 37.8-236 14.7-92.1 28.2-175.5 38.3-235.8 5-30.2 9.2-54.6 12.3-71.4 1.5-8.4 2.7-14.9 3.6-19.4 0.9-4.4 1.4-6.7 1.6-6.7 0.2 0.1 0 2.4-0.6 6.9-0.6 4.5-1.5 11-2.8 19.5-2.5 16.9-6.4 41.3-11.3 71.5-9.8 60.4-23.9 143.7-39.7 235.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m543.9 370.5c-30.3 88.5-57.8 168.6-77.7 226.6-9.8 29-17.7 52.5-23.2 68.8-2.7 8.1-4.8 14.4-6.2 18.7q-1 3.2-1.6 4.9-0.5 1.7-0.4 1.7 0 0 0.7-1.6 0.6-1.7 1.7-4.8c1.5-4.4 3.7-10.6 6.5-18.7 5.5-16.3 13.4-39.8 23.2-68.7 19.4-58.3 46.1-138.6 75.7-227.3 29.4-88.7 56.2-169 75.9-227 9.9-29 18-52.5 23.8-68.7 2.8-8 5.1-14.3 6.7-18.5 1.6-4.2 2.5-6.4 2.7-6.4 0.1 0.1-0.5 2.4-1.7 6.7-1.3 4.3-3.3 10.7-6 18.8-5.2 16.3-13 39.9-22.7 68.9-19.5 58.1-46.9 138.2-77.4 226.6z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m563.9 378.8c-44.3 82.7-84.4 157.6-113.4 211.9-14.4 27.1-26 49.1-34.1 64.3-3.9 7.6-7 13.5-9.1 17.6q-1.5 3-2.4 4.6-0.7 1.6-0.7 1.6 0.1 0 0.9-1.5 0.9-1.6 2.5-4.5c2.2-4.1 5.4-9.9 9.5-17.4 8-15.3 19.7-37.3 34.1-64.4 28.5-54.5 67.9-129.7 111.4-212.8 43.5-83.2 83-158.4 111.9-212.6 14.4-27.2 26.2-49.1 34.5-64.2 4.1-7.5 7.4-13.3 9.6-17.3 2.3-3.9 3.5-5.9 3.7-5.9 0.2 0.1-0.8 2.3-2.8 6.4-2 4-5 10-8.9 17.7-7.8 15.3-19.3 37.3-33.6 64.5-28.7 54.4-68.7 129.3-113.1 212z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m582.3 390c-57 75-108.7 142.8-146.1 192-18.6 24.6-33.6 44.6-44 58.4-5.1 6.9-9.1 12.3-11.9 16q-1.9 2.7-3 4.2-1 1.4-1 1.4 0.1 0.1 1.2-1.3 1.1-1.5 3.2-4.1c2.8-3.6 6.9-9 12.1-15.8 10.4-13.8 25.5-33.7 44-58.3 37-49.6 88-117.9 144.4-193.3 56.3-75.5 107.3-143.8 144.6-193 18.6-24.6 33.8-44.5 44.4-58.1 5.3-6.8 9.5-12.1 12.3-15.7 2.9-3.5 4.5-5.3 4.6-5.2 0.1 0.1-1.1 2.1-3.8 5.8-2.6 3.7-6.5 9.2-11.6 16.1-10.2 14-25.1 34-43.6 58.7-37.1 49.4-88.7 117.3-145.8 192.2z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m598.7 403.8c-68.3 65.5-130.2 124.7-175.1 167.6-22.2 21.5-40.3 39-52.8 51.1-6.1 6-10.9 10.7-14.2 13.9q-2.4 2.4-3.7 3.7-1.2 1.3-1.2 1.3 0.1 0.1 1.4-1.1 1.3-1.3 3.8-3.6c3.3-3.2 8.2-7.8 14.4-13.7 12.6-12.1 30.6-29.5 52.9-51 44.4-43.4 105.7-103.1 173.5-169.2 67.7-66 129.1-125.7 173.8-168.7 22.3-21.5 40.5-38.8 53.1-50.7 6.4-5.9 11.3-10.5 14.7-13.6 3.4-3 5.2-4.6 5.4-4.5 0.1 0.1-1.5 1.9-4.7 5.2-3.2 3.3-7.9 8.1-14.1 14.2-12.3 12.2-30.2 29.7-52.4 51.3-44.5 43.2-106.4 102.5-174.8 167.8z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m612.7 420c-78 54.3-148.6 103.5-199.8 139.1-25.4 17.9-46 32.4-60.3 42.4-7.1 5-12.6 9-16.3 11.7q-2.8 1.9-4.2 3-1.5 1.1-1.4 1.2 0 0 1.5-1 1.5-1 4.3-2.9c3.8-2.7 9.4-6.5 16.5-11.4 14.3-10.1 34.9-24.5 60.4-42.4 50.8-36.1 121-85.8 198.5-140.8 77.4-55.1 147.6-104.8 198.6-140.5 25.5-17.8 46.2-32.2 60.6-42 7.2-4.9 12.9-8.7 16.7-11.2 3.8-2.5 5.9-3.8 6-3.6 0.1 0.1-1.8 1.6-5.4 4.4-3.7 2.7-9.1 6.7-16.2 11.8-14.1 10.3-34.6 24.9-60 42.8-50.9 36-121.5 85.2-199.5 139.4z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m623.9 438.1c-85.8 41.8-163.4 79.6-219.7 107-28 13.8-50.7 25-66.4 32.7-7.8 3.9-13.8 7-18 9.1q-3 1.5-4.7 2.4-1.5 0.8-1.5 0.8 0 0.1 1.6-0.6 1.7-0.8 4.8-2.3c4.2-2 10.3-4.9 18.1-8.7 15.8-7.8 38.4-18.9 66.5-32.7 56-27.9 133.3-66.4 218.7-109 85.3-42.6 162.6-81 218.8-108.5 28-13.8 50.8-24.8 66.6-32.3 7.9-3.8 14.1-6.7 18.3-8.5 4.2-1.9 6.4-2.9 6.5-2.7 0.1 0.1-2 1.4-6.1 3.5-4 2.2-10.1 5.3-17.9 9.3-15.5 7.9-38.1 19.3-66.2 33.1-56 27.8-133.6 65.7-219.4 107.4z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m632.1 457.6c-91.5 28.2-174.3 53.6-234.3 72.1-29.9 9.4-54.1 16.9-70.9 22.2-8.3 2.7-14.8 4.7-19.2 6.2q-3.3 1-5 1.6-1.7 0.6-1.7 0.7 0 0 1.7-0.5 1.8-0.5 5.1-1.4c4.5-1.4 11-3.4 19.3-5.9 16.8-5.3 41-12.8 70.9-22.1 59.9-19 142.4-45.2 233.6-74.2 91.2-29 173.8-55.2 233.7-73.7 29.9-9.3 54.2-16.8 71-21.8 8.4-2.4 15-4.3 19.4-5.6 4.5-1.2 6.8-1.8 6.9-1.6 0.1 0.2-2.2 1-6.6 2.6-4.3 1.5-10.8 3.7-19.1 6.4-16.7 5.5-40.8 13.2-70.8 22.6-59.8 18.8-142.6 44.4-234 72.4z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <path id="&lt;Path&gt;" class="s0" d="m637 478.2c-95 13.8-180.8 26.3-243.1 35.4-31 4.6-56.1 8.4-73.6 11-8.6 1.4-15.3 2.4-20 3.2q-3.3 0.5-5.2 0.9-1.7 0.3-1.7 0.3 0 0.1 1.8-0.1 1.8-0.3 5.2-0.7c4.6-0.7 11.4-1.6 20-2.9 17.5-2.6 42.6-6.3 73.6-11 62.2-9.6 148-22.8 242.7-37.5 94.7-14.7 180.5-27.9 242.7-37.1 31.1-4.6 56.3-8.2 73.7-10.5 8.7-1.2 15.5-2.1 20.1-2.6 4.6-0.6 7-0.8 7-0.6 0 0.2-2.3 0.7-6.9 1.5-4.5 0.9-11.3 2-19.9 3.5-17.4 2.8-42.5 6.7-73.6 11.5-62.1 9.4-148 22-242.8 35.7z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
                <g id="Desk">
                    <g id="&lt;Group&gt;">
                        <path id="&lt;Path&gt;" class="s1" d="m915.5 967.5c0 0.3-187.5 0.5-418.7 0.5-231.2 0-418.7-0.2-418.7-0.5 0-0.3 187.5-0.5 418.7-0.5 231.2 0 418.7 0.2 418.7 0.5z"/>
                    </g>
                </g>
                <g id="Character">
                    <g id="&lt;Group&gt;">
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s2" d="m712.9 857.3l-3.4 27.3c0 0-0.6 2.7-0.9 12.8-0.2 10.1-1.2 23.2-1.7 31.7-0.4 8.5-3.9 12.9-11.8 9.1-8-3.8-4.5-25.3-7.6-43.5-3.1-18.2 5.9-38.5 5.9-38.5z"/>
                                    <path id="&lt;Path&gt;" class="s2" d="m727.8 844.3c0 0 12.5 49.8 12.5 56-0.1 6.1-4 14.8-4 14.8 0 0-3.8 21.8-5.9 24.4-2 2.7-22.3 6.2-22.3 6.2l-13-7.5 5.2-11.3 11.3 1.8 2.6-9.3-7.3-10.8-6.3-52z"/>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s3" d="m714.8 882.7c0.1 0.1-0.2 1-0.7 2.6-0.4 1.6-1.2 4-1.9 6.9-1.6 5.9-3.3 14.2-4 23.4-0.2 2.3-0.3 4.6-0.4 6.8-0.1 2.1-0.1 4.3-0.4 6.3-0.5 4.1-2.5 7.7-5.3 9.3-2.8 1.7-5.7 1.1-7.2 0.2-0.7-0.5-1.2-1-1.5-1.4-0.2-0.4-0.3-0.6-0.3-0.6 0.1-0.1 0.6 0.8 2 1.6 1.4 0.7 4.1 1.2 6.6-0.4 2.5-1.5 4.3-4.9 4.8-8.8 0.2-2 0.2-4.1 0.3-6.3 0-2.2 0.1-4.4 0.3-6.8 0.8-9.3 2.6-17.6 4.4-23.5 0.8-2.9 1.7-5.2 2.3-6.8 0.6-1.6 1-2.5 1-2.5z"/>
                                    </g>
                                </g>
                                <path id="&lt;Path&gt;" class="s2" d="m693.4 856.2l-9-30.7c0 0 32.9-23.3 34.7-21.8 1.8 1.6 10.1 46 10.1 46l-16.9 18.1z"/>
                            </g>
                        </g>
                        <use id="&lt;Path&gt;" href="#img1" x="557" y="366"/>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m646.2 967.5h-125.2c-9.4-56.9 1.6-139.3 1.6-139.3l138.4-68c0 0 16.9 98-14.8 207.3z"/>
                                    <path id="&lt;Path&gt;" class="s1" d="m546.3 967.5h-171.9c-5.8-19.2-14.5-56.8-17.3-70.1-18.4-88.6 40.1-177.6 40.1-177.6l145.6 118.2c0 0-0.9 66.9 3.5 129.5z"/>
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <path id="&lt;Path&gt;" class="s1" d="m661.7 762.1c0.6-0.2-117.6 86.3-117.6 86.3l-158.4-107.5 29.3-55.9c0 0 81 34.5 123.1 25.9 42-8.7 88-46.2 88-46.2 10.4 22.5 29.2 72.5 35.6 97.4z"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <path id="&lt;Path&gt;" class="s4" d="m584.2 783q0.1 0-0.6 1-0.7 1.1-2 3.1-2.8 4.1-8 11.8c-7.1 10.3-17.3 25.3-30.2 44.2 1.6 16.5 2.2 35.7 3.4 56.9 1 21.4 0.4 42.2 1.7 67.5h-1.7c-1.2-25.2-0.5-46.1-1.5-67.4-1-21.4-1.6-40.6-3.1-57.1v-0.2l0.1-0.1c13.2-18.9 23.6-33.9 30.8-44.1q5.3-7.6 8.2-11.7 1.4-1.9 2.2-3 0.7-1 0.7-0.9z"/>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m576.5 162.9c15.8 12.5 24.8 33.1 23.3 53.1-0.8 9.8-3.4 20.9 2.9 28.3 6.3 7.4 18.6 7.2 24.6 14.8 7.1 8.9 1.2 22.2 3.7 33.3 2.4 10.4 13.4 18.1 24 16.7-12.5 10.2-27.7 16.8-43.7 19q-6.1-7.9-12.2-15.7c4.7 5.5 3.4 14.2-1 19.8-4.5 5.6-11.4 8.7-18.3 10.9-32.7 10.3-70.1 4.2-97.9-16"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m393.3 249c2.4-7.4 6.5-14.4 8.2-22 3.5-16.6-4.5-35.2 3.5-50 5.7-10.6 17.8-15.8 29.3-19.3 11.5-3.6 23.8-6.6 32.4-15 6.3-6.2 9.9-14.7 16.1-20.9 9-8.9 22.1-11.9 34.7-12.7 12.9-0.7 26.2 0.5 37.8 6.2 11.6 5.7 21.2 16.3 23.2 29.1 1.1 6.2 0.3 12.7 2.3 18.7 2.1 6.6 7.3 11.7 10.5 17.8 6.7 13 3 30.5-8.3 39.7l-88.5 114.2c-18.5 7-63.6-1.4-77.9-15.2-14.4-13.7-29.5-51.7-23.3-70.6z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s2" d="m586.7 291.1c-3.5 44-36.4 52.1-36.4 52.1 0-0.2 0.5 6.3 1.5 22.1l1.4 30.9c-1.2 12.2 10.2 44.9-0.1 49-46.5 18.5-91.6-42.1-101.1-56-0.6-0.9 0.3-2 1.3-1.6 3.8 1.5 14.4-6.2 14.5-6.2l-17.3-179.3c-0.7-7.9-6.3-20.7 1.5-22.1l79.5-26.8c25.8-4.7 45.5 25.9 49.1 51.9 4.1 28.8 7.9 64.1 6.1 86z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <path id="&lt;Path&gt;" class="s1" d="m567.3 245.1c0.3 3-1.9 5.7-4.9 6.1-3.1 0.4-5.8-1.7-6.2-4.6-0.3-2.9 1.9-5.6 5-6 3-0.4 5.8 1.6 6.1 4.5z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <path id="&lt;Path&gt;" class="s1" d="m512.8 248c0.3 2.9-1.9 5.6-5 6-3 0.4-5.8-1.6-6.1-4.5-0.3-3 1.9-5.7 5-6.1 3-0.4 5.8 1.7 6.1 4.6z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m577.1 227.6c-0.6 1.1-5.8-2.2-12.3-1.3-6.5 0.9-10.6 5.4-11.5 4.6-0.4-0.4 0.1-2.1 1.9-4.2 1.8-2 5-4.2 9-4.8 4.1-0.5 7.8 0.7 10 2.2 2.3 1.5 3.2 3.1 2.9 3.5z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m518.8 232.4c-0.7 1-5.8-2.7-12.8-2.4-7 0.2-12 4.2-12.8 3.3-0.3-0.4 0.4-2 2.6-3.9 2.1-1.8 5.7-3.6 10.1-3.8 4.3-0.1 8.1 1.5 10.3 3.1 2.2 1.7 3 3.3 2.6 3.7z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                                <path id="&lt;Path&gt;" class="s1" d="m540.7 273.5c-0.1-0.3 3.6-1.2 9.6-2.5 1.5-0.2 2.9-0.7 3.1-1.7 0.3-1.2-0.5-2.8-1.3-4.5q-2.6-5.4-5.5-11.3c-7.5-16.1-13.1-29.4-12.5-29.7 0.7-0.3 7.3 12.5 14.9 28.6q2.7 6 5.2 11.4c0.7 1.7 1.9 3.6 1.3 6-0.3 1.1-1.4 2.1-2.4 2.4-0.9 0.4-1.8 0.5-2.5 0.6-6.1 0.8-9.8 1.1-9.9 0.7z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <path id="&lt;Path&gt;" class="s3" d="m551.1 355.1c-43.2 7.4-60.2-22-60.2-22 30.3 15.2 59.4 11.1 59.4 11.1z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s3" d="m522.4 291c0.8-1.4 1.7-2.8 3.1-3.6 1.5-0.9 3.4-0.9 5.2-0.5 2.5 0.4 5 1.5 6.8 3.4 1.7 1.9 2.6 4.8 1.7 7.2-0.7 2.5-4.4 3.9-7 4.3-2.5 0.5-5.2-0.3-7.5-1.6-1.9-1-3.7-2.7-3.8-4.9 0-1.5 0.7-2.9 1.5-4.3z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <g id="&lt;Group&gt;">
                                                                                    <g id="&lt;Group&gt;">
                                                                                        <g id="&lt;Group&gt;">
                                                                                            <g id="&lt;Group&gt;">
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <path id="&lt;Path&gt;" class="s1" d="m518.3 209c-0.5 1.7-6.5 1.3-13.5 2.7-7 1.3-12.5 3.8-13.5 2.4-0.5-0.7 0.4-2.3 2.5-4.1 2.2-1.7 5.7-3.5 9.9-4.3 4.2-0.8 8.1-0.4 10.7 0.5 2.7 0.8 4.1 2 3.9 2.8z"/>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <g id="&lt;Group&gt;">
                                                                    <g id="&lt;Group&gt;">
                                                                        <g id="&lt;Group&gt;">
                                                                            <g id="&lt;Group&gt;">
                                                                                <path id="&lt;Path&gt;" class="s1" d="m573.4 205.7c-1.1 1.4-5.9 0.4-11.6 0.8-5.7 0.2-10.4 1.7-11.6 0.3-0.6-0.6 0.1-2 2.1-3.5 2-1.4 5.3-2.7 9.2-2.9 4-0.2 7.4 0.7 9.5 2 2.1 1.2 2.9 2.6 2.4 3.3z"/>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m434.4 187.2c4-6.2 11.2-9.3 18.1-12 29.6-11.4 60.6-19.3 92.1-23.4 3.9 6.4 0.3 15.2-5.6 19.9-5.9 4.7-13.5 6.6-20.6 9.2-7.1 2.7-14.4 6.8-17.3 13.7-3.1 7.5-0.5 16.2-3.2 23.8-4.7 13-22.8 17.2-27.5 30.2-3.4 9.9 2.3 20.4 3.7 30.8 1.6 11.7-2.7 24.1-11.3 32.3-6.8 6.4-16.1 10.1-25.4 10.2q-3.2-56-6.5-112c-0.4-7.8-0.7-16.2 3.5-22.7z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m359.2 281.6c5.9-5.3 13.3-9.9 15.6-17.5 3.5-11-5.4-23.9 0.3-34 5.2-9.1 20.5-8.6 25.3-18 3.8-7.3-0.5-13.8 0.9-20.2 1.4-6.4 10.5-12 17.1-11.2l51 73.9c4.7 24.8 9.5 38 4.1 52.5-2.9 7.9-6.7 15.7-7.8 24.1-1.2 8.4 1 17.9 7.8 22.9-30.5 2.4-59-13.6-85.4-29q-14-8.2-28-16.4c-2.9-1.7-5.9-3.5-7.7-6.4-4.1-6.7 0.9-15.5 6.8-20.7z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s4" d="m399.9 316.9c3.9-1.1 8.6-3.2 12.7-7.2 4.1-4 7.4-10.1 8.2-17.2 0.3-3.6 0.1-7.5-1.1-11.2-1.1-3.8-3.3-7.3-5.6-11-2.3-3.6-4.8-7.4-6.1-12.1-1.2-4.5-1.3-10 1.9-14.3 1.5-2.1 3.9-3.6 6.2-4.5 2.4-1 4.8-1.7 7.1-2.6 2.3-1 4.4-2.3 5.7-4.3 1.4-1.9 1.9-4.4 1.8-7 0-5.1-2.3-10-3.4-15.5-0.6-2.8-0.8-5.7-0.1-8.6 0.8-2.9 2.7-5.5 5.1-7.2 4.9-3.5 11-3.9 16.3-4.4 5.4-0.4 10.6-1.5 15-4.4 4.3-2.7 7.9-6.5 10.1-10.9 2.3-4.4 3.1-9.3 3.9-14.1 0.8-4.8 1.4-9.6 3.1-14 1.7-4.4 4.5-8.3 7.7-11.3 6.4-6.1 14.5-9.2 22-9.8 7.5-0.5 14.2 1.5 19.4 4.3 5.2 2.8 9.1 6.3 11.8 9.4 2.7 3.1 4.4 5.9 5.4 7.8 0.5 1 0.8 1.8 1.1 2.3q0.3 0.7 0.3 0.8c-0.3 0.1-1.8-4.4-7.3-10.4-2.8-3-6.6-6.4-11.7-9-5.1-2.6-11.7-4.5-18.9-3.9-7.2 0.6-15 3.7-21.1 9.5-3 3-5.6 6.6-7.2 10.8-1.6 4.3-2.3 8.9-3 13.7-0.7 4.8-1.6 9.9-4 14.7-2.3 4.6-6.1 8.7-10.7 11.6-4.6 3-10.3 4.2-15.7 4.6-5.4 0.5-11.1 1-15.5 4.2-2.1 1.5-3.7 3.7-4.4 6.1-0.6 2.5-0.4 5.2 0.1 7.8 1 5.2 3.4 10.3 3.5 15.9 0 2.8-0.5 5.7-2.1 8-1.6 2.4-4.1 3.9-6.5 4.8-4.8 2-10 2.9-12.7 6.6-2.8 3.6-2.8 8.7-1.7 12.9 1.2 4.3 3.6 8.1 5.9 11.8 2.2 3.6 4.5 7.3 5.6 11.3 1.2 4 1.4 8 1 11.7-0.8 7.5-4.3 13.8-8.7 17.8-4.3 4.1-9.2 6.2-13.2 7.1-4.1 1-7.4 0.9-9.5 0.7-2.2-0.2-3.3-0.6-3.3-0.6 0-0.3 4.6 1.3 12.6-0.7z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m346 267.6c-0.3 1.7-0.1 4.4 1.5 7.2 0.9 1.3 2.1 2.7 3.8 3.7 1.6 0.9 3.8 1.5 6 1.4 4.6 0 9.8-2.8 12.3-8 1.3-2.6 1.9-5.6 1.9-8.7 0-3.2-0.9-6.4-2.1-9.6-1.3-3.2-2.9-6.4-4.4-9.9-1.5-3.4-2.7-7.2-2.8-11.3-0.1-4 0.8-8.5 4-11.7 3.2-3.3 8-4 12.2-4 4.3-0.2 8.7 0.3 12.6-1.3 3.9-1.5 6.1-5.6 6.5-9.9 0.6-4.3-0.5-8.7-1-13.1-0.7-4.4-0.5-9 0.7-13.3 2.4-8.4 8.1-15.5 15.1-19.5 7-4.2 15-4.5 21.9-4.9 6.9-0.3 13.4-0.7 18.9-2.8 5.5-1.9 10-5 13.4-8.1 3.5-3.1 5.9-6.4 7.6-9.2 3.4-5.7 4-9.4 4.2-9.4 0 0-0.4 3.8-3.6 9.7-1.6 2.9-4 6.4-7.5 9.6-3.4 3.3-8 6.5-13.7 8.6-5.6 2.3-12.3 2.7-19.3 3.1-6.8 0.4-14.5 0.8-21.1 4.8-6.6 3.9-11.9 10.6-14.2 18.6-1.1 4-1.4 8.3-0.7 12.6 0.6 4.3 1.7 8.8 1.1 13.5-0.3 2.4-0.9 4.7-2.2 6.8-1.3 2-3.3 3.6-5.4 4.5-4.5 1.8-9.1 1.3-13.3 1.4-4.1 0-8.3 0.7-11 3.5-2.8 2.6-3.7 6.7-3.6 10.4 0.1 7.8 4.5 14.2 6.9 20.8 1.3 3.3 2.2 6.7 2.2 10.1 0 3.3-0.8 6.5-2.2 9.3-2.8 5.6-8.5 8.5-13.4 8.4-2.4 0.1-4.7-0.6-6.5-1.7-1.8-1.1-3-2.6-3.9-4.1-1.6-3-1.7-5.8-1.3-7.6 0.4-1.7 1-2.5 1-2.5 0.1 0.1-0.4 0.9-0.6 2.6z"/>
                                    </g>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m668.8 285.3c0.4 1.3 0.6 3.5-0.3 6.2-0.8 2.5-2.8 5.7-6.6 7.1-3.8 1.4-8.9 0.5-12.5-3.1-1.7-1.8-2.8-4.5-3-7.2-0.2-2.7 0.3-5.5 1.1-8.2 1.7-5.5 4.7-10.9 4.2-17-0.4-6.1-3.5-12.3-8.7-16.4-2.6-2-5.7-3.6-9-4.6-3.3-1.1-6.8-1.3-10.4-1.5-3.6-0.2-7.3-0.3-10.9-1.2-3.6-0.8-7-2.8-9.2-5.8-2.1-3-3-6.5-3.2-9.9-0.3-3.4 0.2-6.7 0.9-9.9 1.3-6.2 3.1-11.9 2.8-17.4-0.2-5.5-2.2-10.4-5-14.1-2.7-3.8-6.3-6.2-9.4-8.3-3.2-2.1-5.9-4-7.9-5.8-2-1.9-3.2-3.7-3.8-5-0.3-0.6-0.5-1.1-0.6-1.4q-0.2-0.6-0.1-0.6c0.2-0.1 0.9 3 5 6.4 2 1.8 4.7 3.5 7.9 5.5 3.2 2 7 4.5 9.9 8.4 3 3.9 5.2 9 5.5 14.8 0.3 5.9-1.5 11.8-2.7 17.9-0.7 3-1.1 6.2-0.8 9.4 0.2 3.2 1 6.4 2.9 9 1.9 2.6 4.9 4.3 8.2 5.1 3.4 0.8 6.9 0.9 10.6 1.1 3.6 0.2 7.3 0.4 10.8 1.6 3.5 1 6.8 2.7 9.5 5 5.6 4.4 9 11.1 9.3 17.6 0.5 6.7-2.8 12.3-4.4 17.5-0.8 2.6-1.3 5.2-1.2 7.7 0.2 2.5 1.1 4.8 2.7 6.4 3.1 3.3 7.8 4.2 11.2 3.1 3.4-1.2 5.4-4.1 6.3-6.5 1.7-5-0.2-8 0.1-7.9 0 0 0.5 0.6 0.8 2z"/>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <use id="&lt;Path&gt;" href="#img2" x="409" y="358"/>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s1" d="m579 747q0 0 0.9-0.2 0.9-0.3 2.6-0.7 1.8-0.4 4.3-0.9 2.5-0.9 5.8-1.9c2.1-0.6 4.4-1.8 7-2.8 2.5-1 5.1-2.5 8-3.9 5.6-3.2 11.8-7.2 18-12.4 6.3-5.1 12.6-11.4 18.6-18.8 0.8-0.9 1.5-1.9 2.2-2.9q1.1-1.4 2.1-3 1.1-1.5 2-3.1 0.5-0.8 0.9-1.6l0.4-0.8 0.3-0.8c0.2-2.4-0.2-5-0.5-7.6q-0.7-3.9-1.6-7.8c-2.3-10.4-5.4-21.3-8.5-32.6-1.6-5.6-3.2-11.3-4.7-17.2-0.8-2.9-1.6-5.9-2.2-8.9-0.4-1.5-0.7-3-0.9-4.6-0.1-1.5-0.1-3.1-0.1-4.6 0.2-12.5 1.5-24.4 2.7-36v-0.1h0.1c5-19.8 9.4-38.7 10.1-55.9 0.1-4.3 0.1-8.5-0.5-12.5-0.5-4-1.7-7.8-2.7-11.5-2.2-7.2-4.8-13.8-7.4-19.6-5.2-11.7-10.5-20.6-14.2-26.6-1.8-3-3.3-5.3-4.4-6.8q-0.7-1.1-1.1-1.8-0.4-0.5-0.4-0.6 0 0 0.5 0.6 0.4 0.5 1.2 1.7c1.1 1.5 2.6 3.7 4.5 6.7 3.8 5.9 9.2 14.8 14.5 26.5 2.6 5.8 5.3 12.4 7.5 19.7 1.1 3.7 2.3 7.5 2.9 11.6 0.6 4 0.6 8.3 0.5 12.6-0.7 17.4-5.1 36.3-10.1 56.1h0.1c-1.3 11.5-2.6 23.6-2.8 35.9 0 1.5 0 3 0.2 4.5 0.2 1.5 0.4 3 0.8 4.5 0.6 3 1.4 5.9 2.2 8.8 1.5 5.9 3.1 11.6 4.7 17.3 3.1 11.2 6.1 22.1 8.5 32.6q0.9 4 1.5 7.9c0.4 2.6 0.8 5.1 0.5 7.8q-0.2 0.5-0.3 1l-0.5 0.9q-0.4 0.9-0.9 1.7-0.9 1.6-2 3.1-1.1 1.6-2.2 3c-0.7 1-1.4 2-2.2 2.9-6.1 7.5-12.5 13.7-18.8 18.9-6.3 5.1-12.5 9.1-18.2 12.3-2.9 1.4-5.6 2.9-8.1 3.9-2.6 1-4.9 2.1-7.1 2.7q-3.3 1-5.8 1.7c-1.7 0.4-3.2 0.7-4.4 1q-1.7 0.3-2.6 0.5-0.9 0.1-0.9 0.1z"/>
                            </g>
                            <g id="&lt;Group&gt;" style="opacity: .3">
                                <path id="&lt;Path&gt;" class="s5" d="m635.2 619.6c-0.4-9.2-3.9-21.2 1.6-45.7 5.9-26 10.5-43.1 10.3-65 5.2 23.8 0.3 48.3-2.7 72.5-3.7 29.8-1.8 60.2 5.5 89.3"/>
                            </g>
                            <path id="&lt;Path&gt;" class="s6" d="m437.1 656c5.1-13.3 9.2-19.5 14.3-33.3l-4.3-9.6 17.3-100.7c0 0-3.8 106.1-4.8 109.5-1.7 5.4-13.7 56.1-23.6 71.2-9.9 15.1-20.7 10.2-20.7 10.2 6.3-3.5 14.5-28 21.8-47.3z"/>
                        </g>
                        <g id="&lt;Group&gt;">
                            <use id="&lt;Path&gt;" href="#img3" x="336" y="376"/>
                            <path id="&lt;Path&gt;" class="s2" d="m357.5 372.2c1.4 4.2-3.2 16.2-3.2 16.2l13.8 11.8 45.8 3.9c0 0-11.1-12.2-15-17.3-4-5.1-4.4-14.2 3.9-15.4 8.3-1.2 27.6 22.1 27.6 22.1 0 0 23.3 19.4 24 38.7 0.8 19.3 0 50 0 50l-39.8-6.8 3.7-25.9-46.3-14.9-24.7-19c0 0-6-23.6-6.1-26.9 0-11.4 8-22 8-22 0 0 6.1-1.2 8.3 5.5z"/>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m353.9 399.3c0.1-0.1 1.8 0.9 4.4 2.6 2.6 1.7 6.1 4.1 10 6.9q0.4 0.2 0.7 0.5h-0.6c4-2.7 8.5-2.9 11.4-2.3 1.5 0.3 2.6 0.7 3.3 1.1 0.8 0.3 1.1 0.6 1.1 0.7-0.1 0.1-1.7-0.7-4.5-1.1-2.8-0.4-7 0-10.7 2.5l-0.3 0.2-0.3-0.2q-0.3-0.3-0.7-0.6c-3.9-2.7-7.4-5.3-9.9-7.1-2.5-1.9-3.9-3.1-3.9-3.2z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m352.2 418.3c0.2 0.2-11.2 21.3-25.6 47.3-14.3 26-26.2 46.9-26.4 46.8-0.3-0.1 11.1-21.3 25.5-47.3 14.4-26 26.2-46.9 26.5-46.8z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m374.3 400.4c0.2 0-0.6 19.9-2 44.4-1.3 24.6-2.6 44.4-2.9 44.4-0.3 0 0.5-19.9 1.9-44.4 1.3-24.6 2.7-44.4 3-44.4z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m376.1 400.9c0.3 0 2.2 21.7 4.3 48.6 2.1 26.9 3.5 48.7 3.2 48.7-0.3 0-2.2-21.7-4.2-48.6-2.1-26.9-3.5-48.7-3.3-48.7z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s4" d="m146.6 781.4l123-283.4 144.7-35.7-120.7 302.8z"/>
                                    <path id="&lt;Path&gt;" class="s4" d="m210.5 812.7l-63.9-31.3 147-16.3 81.6 38.6z"/>
                                    <path id="&lt;Path&gt;" class="s6" d="m210.5 812.7l-63.9-31.3 147-16.3 81.6 38.6z"/>
                                    <path id="&lt;Path&gt;" class="s4" d="m414.3 462.3l3.3 13.3 22.4-0.7-64.8 328.8-81.6-38.6z"/>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m414.3 462.3q0 0.1-0.4 1.2-0.4 1.1-1.2 3.2c-1.1 2.9-2.8 7.1-4.9 12.4-4.2 10.8-10.4 26.4-18 45.7-15.3 38.5-36.5 91.6-59.8 150.4-12.9 32.2-25.1 62.8-36 90l-0.7-0.6c20.2-10.1 38.4-19.2 54.2-27.1l0.4-0.2 0.1 0.4c8.5 20.3 15.3 36.8 20 48.2 2.4 5.7 4.2 10.1 5.4 13.1q0.9 2.3 1.4 3.5 0.4 1.1 0.4 1.2 0 0-0.5-1.2-0.5-1.2-1.5-3.4c-1.3-3-3.2-7.4-5.6-13-4.8-11.4-11.7-27.8-20.3-48.1l0.5 0.2c-15.7 7.9-33.9 17.1-54 27.3l-1.1 0.5 0.4-1.1c10.9-27.3 23.1-57.9 35.9-90.1 23.5-58.7 44.7-111.8 60.1-150.3 7.8-19.2 14-34.7 18.4-45.5 2.1-5.4 3.8-9.5 5-12.4q0.9-2 1.3-3.2 0.5-1.1 0.5-1.1z"/>
                                    </g>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m417.6 475.6c0.2 0-15.2 58.8-34.5 131.2-19.3 72.5-35.1 131.1-35.4 131-0.3 0 15.1-58.8 34.4-131.2 19.3-72.5 35.2-131.1 35.5-131z"/>
                                    </g>
                                    <path id="&lt;Path&gt;" class="s6" d="m414.3 462.3l3.3 13.3-69.9 262.2-54.1 27.3z"/>
                                </g>
                            </g>
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m342.4 395.5c0.3 0.1-19.2 21.6-43.5 47.9-24.2 26.3-44 47.5-44.2 47.3-0.3-0.2 19.2-21.7 43.5-48 24.2-26.3 44-47.4 44.2-47.2z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s7" d="m101.1 713.9l123-242.7 144.7-30.5-120.8 259.2z"/>
                                    <path id="&lt;Path&gt;" class="s7" d="m165 740.7l-63.9-26.8 146.9-14 81.7 33z"/>
                                    <path id="&lt;Path&gt;" class="s6" d="m165 740.7l-63.9-26.8 146.9-14 81.7 33z"/>
                                    <path id="&lt;Path&gt;" class="s7" d="m368.8 440.7l3.2 11.3 22.5-0.6-64.8 281.5-81.7-33z"/>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m368.8 440.7q0 0-0.4 0.9-0.4 1-1.2 2.9c-1.2 2.5-2.8 6.1-5 10.8-4.3 9.4-10.6 22.9-18.3 39.6-15.5 33.5-37 79.7-60.7 130.7-12.4 26.5-24.1 51.8-34.7 74.5l-0.6-0.7c20.2-8.7 38.5-16.5 54.1-23.2l0.4-0.1 0.1 0.3c8.4 17.4 15.3 31.5 20 41.3 2.3 4.9 4.2 8.6 5.4 11.3q0.9 1.8 1.4 2.9 0.4 1 0.4 1 0 0-0.5-1-0.5-1-1.5-2.9c-1.3-2.5-3.2-6.3-5.6-11.1-4.8-9.8-11.7-23.8-20.3-41.2l0.5 0.2c-15.6 6.8-33.8 14.7-54.1 23.4l-1.1 0.5 0.5-1.1c10.6-22.7 22.3-48 34.7-74.5 23.8-51 45.3-97.1 61-130.6 7.8-16.6 14.1-30.1 18.6-39.5 2.2-4.6 3.9-8.2 5.1-10.7q0.8-1.8 1.3-2.8 0.5-0.9 0.5-0.9z"/>
                                    </g>
                                    <g id="&lt;Group&gt;">
                                        <path id="&lt;Path&gt;" class="s1" d="m372 452c0.3 0.1-15.1 50.4-34.4 112.4-19.3 62-35.2 112.2-35.4 112.2-0.3-0.1 15.1-50.5 34.4-112.5 19.3-62 35.2-112.2 35.4-112.1z"/>
                                    </g>
                                    <path id="&lt;Path&gt;" class="s6" d="m368.8 440.7l3.2 11.3-69.8 224.6-54.2 23.3z"/>
                                </g>
                                <g id="&lt;Group&gt;">
                                    <path id="&lt;Path&gt;" class="s1" d="m283.3 458.7q0 0 1.5-0.4 1.7-0.4 4.4-1c3.9-0.9 9.4-2.1 16.1-3.6 13.8-3 32.6-7 53.4-11.4q5.1-1.1 10-2.1l0.5-0.1 0.1 0.4q1.7 5.8 3.2 11.3l-0.5-0.3c8.2-0.2 15.7-0.4 22.5-0.5h0.5l-0.1 0.5c-2.3 9.6-4.2 17.5-5.5 23.2q-1 4-1.6 6.4-0.3 1-0.5 1.6-0.1 0.6-0.2 0.6 0 0 0.1-0.6 0.1-0.7 0.3-1.7 0.5-2.4 1.4-6.5c1.3-5.6 3-13.6 5.2-23.2l0.4 0.5c-6.8 0.2-14.3 0.4-22.4 0.7h-0.4l-0.1-0.4q-1.6-5.5-3.3-11.3l0.6 0.4q-4.9 1-10 2.1c-20.8 4.3-39.6 8.2-53.4 11.1-6.8 1.4-12.3 2.5-16.2 3.3q-2.8 0.5-4.4 0.8-1.6 0.3-1.6 0.2z"/>
                                </g>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m375.4 422.6c-0.2 0.1-1.5-2.7-5.1-5.9-1.9-1.6-4.3-3.2-7.3-4.2-1.5-0.6-3.2-0.8-4.9-1.3-0.9-0.3-1.8-0.8-2.5-1.5-0.8-0.7-1.2-1.7-1.4-2.7-0.3-2-0.1-3.8-0.4-5.5-0.2-1.7-0.6-3.3-1.1-4.8-0.6-1.5-1.2-2.9-2-4-0.8-1.2-1.9-1.8-3-2.2-1.1-0.4-2.2-0.4-3-0.1-0.8 0.4-1.3 1-1.6 1.6-0.5 1.2-0.5 2-0.7 2q0 0 0-0.5c0-0.4 0.1-1 0.3-1.6 0.3-0.7 0.8-1.5 1.8-2 0.9-0.5 2.2-0.4 3.4-0.1 1.2 0.3 2.6 1.1 3.5 2.4 0.9 1.2 1.6 2.6 2.2 4.1 0.6 1.6 1 3.3 1.2 5.1 0.3 1.8 0.1 3.7 0.5 5.4 0.1 0.8 0.4 1.6 1 2.2 0.6 0.6 1.3 0.9 2.1 1.2 1.6 0.5 3.3 0.8 4.9 1.4 3.1 1.1 5.6 2.8 7.4 4.5 1.9 1.7 3.1 3.4 3.8 4.6 0.7 1.2 0.9 1.9 0.9 1.9z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m351.4 366.9c0.1 0.1-0.9 1.4-2.2 3.5-1.4 2.2-2.9 5.4-4.1 9.1-2.3 7.5-2.4 14-2.8 13.9-0.1 0-0.2-1.6 0-4.2 0.2-2.6 0.7-6.1 1.8-10 1.2-3.8 2.9-7 4.4-9.2 1.6-2.1 2.8-3.2 2.9-3.1z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s1" d="m356.9 390.6c0.3 0.1-5 13.1-11.9 29.1-6.9 16-12.7 28.8-12.9 28.7-0.3-0.1 5.1-13.1 11.9-29.1 6.9-16 12.7-28.8 12.9-28.7z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s1" d="m361 394.1c0.3 0.1-2.7 11.5-6.6 25.6-3.9 14.1-7.3 25.4-7.5 25.4-0.3-0.1 2.6-11.6 6.5-25.7 3.9-14 7.3-25.4 7.6-25.3z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m425.4 405.8c0 0.3-8.7-0.3-19.4-1.4-10.6-1.1-19.2-2.2-19.2-2.5 0-0.3 8.7 0.4 19.3 1.4 10.7 1.1 19.3 2.2 19.3 2.5z"/>
                            </g>
                            <g id="&lt;Group&gt;">
                                <path id="&lt;Path&gt;" class="s3" d="m418.3 387c0.3 0.2-1 2.5-3.4 4.5-2.5 2.1-4.9 2.9-5 2.7-0.2-0.3 2-1.5 4.3-3.5 2.3-1.9 3.9-3.8 4.1-3.7z"/>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <path id="&lt;Path&gt;" class="s1" d="m440 479.7q0 0 0.5 0.1 0.5 0 1.4 0.2 1.9 0.3 5.4 0.9c4.8 0.8 11.8 2.1 20.5 3.6l0.3 0.1v0.3c-2.7 24.4-7.6 63.5-16.1 107-3.6 18.5-7.6 36-11.6 51.9-3.7 15.9-7.2 30.2-11.9 41.7-2.4 5.7-5.2 10.8-9 14-3.6 3.4-7.4 5.5-10.6 6.8-3.2 1.4-5.9 1.9-7.7 2.1-1.8 0.2-2.8 0.2-2.8 0.2q0 0 0.7-0.1 0.7-0.1 2.1-0.3c1.8-0.3 4.4-0.9 7.5-2.2 3.2-1.4 6.8-3.6 10.4-6.9 3.7-3.2 6.4-8.2 8.7-13.9 4.6-11.4 8.1-25.7 11.7-41.7 3.9-15.8 7.9-33.3 11.5-51.8 8.5-43.5 13.5-82.6 16.4-106.9l0.3 0.3c-8.7-1.6-15.6-3-20.5-3.9q-3.4-0.7-5.4-1.1-0.8-0.1-1.4-0.3-0.4-0.1-0.4-0.1z"/>
                        </g>
                    </g>
                </g>
                <g id="Speech Bubble">
                    <g id="&lt;Group&gt;">
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <path id="&lt;Path&gt;" class="s8" d="m688.7 281.9l7.8-23.5c-7.9-11.8-12.7-25.8-13.3-41-1.6-43.6 32.5-80.3 76.2-81.9 43.6-1.6 80.3 32.5 81.9 76.1 1.6 43.7-32.5 80.3-76.1 81.9-18.3 0.7-35.3-4.9-49-14.7z"/>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <g id="&lt;Group&gt;">
                                                <g id="&lt;Group&gt;">
                                                    <g id="&lt;Group&gt;">
                                                        <g id="&lt;Group&gt;">
                                                            <g id="&lt;Group&gt;">
                                                                <path id="&lt;Path&gt;" class="s1" d="m688.7 281.9c0 0 0.6-0.1 1.8-0.2q1.8-0.3 5.3-0.7c4.6-0.5 11.5-1.4 20.4-2.4l-0.2 0.4v-0.1c-0.1-0.1-0.1-0.2 0-0.3 0.1-0.1 0.3-0.1 0.3 0 8.5 5.9 20.7 12.2 36.4 14 3.9 0.5 7.9 0.7 12.2 0.5 4.1-0.3 8.5-0.5 12.9-1.6 8.8-1.7 17.8-5.1 26.2-10.5 8.5-5.3 16.3-12.5 22.5-21.4 6.2-8.9 10.8-19.4 13-30.8 4.4-22.8-2.3-49.1-19.8-67.7-8.9-9.4-19.8-16.7-31.7-20.7-11.8-4.1-24.2-5.2-35.9-3.7-11.8 1.4-22.7 5.7-32 11.6-9.3 6-17 13.6-22.7 21.9-5.7 8.4-9.5 17.4-11.6 26.2q-0.4 1.7-0.7 3.3c-0.3 1.1-0.5 2.2-0.6 3.3q-0.4 3.2-0.7 6.4c-0.1 4.2-0.3 8.3 0.1 12.3 1.4 15.7 7.2 28.1 12.8 36.5q0 0.1 0 0.3c-2.6 7.5-4.6 13.4-5.9 17.3q-1 3-1.6 4.6c-0.3 1-0.5 1.5-0.5 1.5q-0.1 0 0.4-1.5 0.5-1.5 1.4-4.5c1.3-4 3.3-9.9 5.7-17.6l0.1 0.2c-5.7-8.4-11.7-20.9-13.1-36.8-0.5-3.9-0.2-8.1-0.2-12.3q0.3-3.2 0.7-6.5c0.1-1.2 0.3-2.3 0.6-3.4q0.3-1.6 0.7-3.3c2.1-8.9 5.9-18 11.7-26.5 5.7-8.4 13.4-16.2 22.9-22.2 9.4-6 20.4-10.4 32.3-11.9 11.9-1.5 24.5-0.3 36.5 3.8 12 4 23.1 11.4 32.1 20.9 1.2 1.2 2.2 2.4 3.2 3.7l3 3.7 2.6 4c0.9 1.3 1.8 2.7 2.5 4.1q1.1 2.1 2.2 4.2c0.7 1.3 1.2 2.9 1.8 4.3 0.6 1.4 1.3 2.9 1.7 4.3q0.7 2.3 1.4 4.5c3.3 11.9 3.8 24.3 1.6 35.9-2.2 11.5-6.8 22.2-13.2 31.2-6.3 9-14.2 16.3-22.8 21.6-8.5 5.4-17.7 8.8-26.5 10.6-4.5 1-8.9 1.2-13.1 1.5-4.3 0.2-8.4 0-12.3-0.5-15.8-2-28.1-8.4-36.5-14.4l0.3-0.4c0.1 0.2 0.1 0.3 0 0.4q-0.1 0-0.1 0.1c-9 0.9-16 1.6-20.7 2.1q-3.4 0.4-5.2 0.6-1.8 0.1-1.7 0.1z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <g id="&lt;Group&gt;">
                            <g id="&lt;Group&gt;">
                                <g id="&lt;Group&gt;">
                                    <g id="&lt;Group&gt;">
                                        <g id="&lt;Group&gt;">
                                            <g id="&lt;Group&gt;">
                                                <use id="Capa 2" href="#img4" x="733" y="182"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
                <use id="Capa 1" href="#img5" transform="matrix(1,0,0,1,516,290)"/>
            </svg>
            <p class="pb-2 center my-0 subtitle-1">El pago ha sido rechazado.</p>
            <a class="mdc-button mdc-button--raised mb-1" href="{{ route('dashboard') }}">
                <span class="mdc-button__label">Ir al Dashboard</span>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        // Selección del item en el menú
        $('#abonos-index').addClass('mdc-list-item--active');

        var idRecepcion = @json($idRecepcion);
        // var urlRecepcionWompi = 'https://sandbox.wompi.co/v1/transactions/' + idRecepcion;
        var urlRecepcionWompi = 'https://production.wompi.co/v1/transactions/' + idRecepcion;
        // var urlRecepcionWompi = 'https://production.wompi.co/v1/transactions/' + '1123820-1668091162-84654'; // APROVADA
        // var urlRecepcionWompi = 'https://production.wompi.co/v1/transactions/' + '1123820-1668720846-70594'; // DECLINADA
        console.log(urlRecepcionWompi);
        var urlActualizaWompi = '{!! route('ajax.abonoWompi.actualizaid', ['busqueda' => 'idPedido', 'idWompi' => 'idWomp']) !!}';
        var usuario = @json($usuario);

        $.ajax({
            method: 'GET',
            url: urlRecepcionWompi
        }).done(function(response) {

            console.log(response);

            if (response.data.status == "APPROVED") {
                $('#mensaje-error').remove();
                $('#mensaje-correcto').css('display', 'block');
            }

            if (response.data.status == "DECLINED") {
                $('#mensaje-correcto').remove();
                $('#mensaje-error').css('display', 'block');
            }
            var urlActualizaWompi2 = urlActualizaWompi.replace('idPedido', response.data.reference).replace('idWomp', response.data.id);
            console.log(urlActualizaWompi2);

            $.ajax({
                method: 'GET',
                url: urlActualizaWompi2
            }).done(function(response) {

                console.log(response);

            });

        });

    });
</script>
@endsection
