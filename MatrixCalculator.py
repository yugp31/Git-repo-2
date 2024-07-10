print("WELCOME TO MATRIX CALCULATOR")

MATRIX_type = input("Enter the type of matrix you want to calculate: ")

if MATRIX_type == "2x2":
    
    print("•Enter the elements of the matrix A")
    
    print("•for matrix A")
    a1 = int(input("A1="))
    b1 = int(input("B1="))
    c1 = int(input("C1="))
    d1 = int(input("D1="))
    
    print("•for matrix B")
    a2 = int(input("A2="))
    b2 = int(input("B2="))
    c2 = int(input("C2="))
    d2 = int(input("D2="))
    
    print("•Matrix A:")
    print(f"[{a1} {b1}]")
    print(f"[{c1} {d1}]")

    print("•Matrix B:")
    print(f"[{a2} {b2}]")
    print(f"[{c2} {d2}]")
    
    print("•adition of matrics A and B")
    print([a1 + a2, b1 + b2])
    print([c1 + c2, d1 + d2])
    
    print("•subtraction of matrics A and B")
    print([a1 - a2, b1 - b2])
    print([c1 - c2, d1 - d2])
    
    print("•multiplication of matrics A and B")
    
    print([(a1 * a2) + (b1 * c2), (a1 * b2) + (b1 * d2)])
    print([(c1 * a2) + (d1 * c2), (c1 * b2) + (d1 * d2)])

elif MATRIX_type == "3x3":
    
    print("•Enter the elements of the matrix A")
    
    print("•for matrix A")
    a1 = int(input("A1=")) 
    b1 = int(input("B1="))
    c1 = int(input("C1="))
    d1 = int(input("D1="))
    e1 = int(input("E1="))
    f1 = int(input("F1="))
    g1 = int(input("G1="))
    h1 = int(input("H1="))
    i1 = int(input("I1="))
    
    print("•for matrix B")
    a2 = int(input("A2="))
    b2 = int(input("B2="))
    c2 = int(input("C2="))
    d2 = int(input("D2="))
    e2 = int(input("E2="))
    f2 = int(input("F2="))
    g2 = int(input("G2="))
    h2 = int(input("H2="))
    i2 = int(input("I2="))

    print("•Matrix A:")
    print(f"[{a1} {b1} {c1}]")
    print(f"[{d1} {e1} {f1}]")
    print(f"[{g1} {h1} {i1}]")

    print("•Matrix B:")
    print(f"[{a2} {b2} {c2}]")
    print(f"[{d2} {e2} {f2}]")
    print(f"[{g2} {h2} {i2}]")
    
    print("•adition of matrics A and B")
    
    print([a1 + a2, b1 + b2, c1 + c2])
    print([d1 + d2, e1 + e2, f1 + f2])
    print([g1 + g2, h1 + h2, i1 + i2])
    
    print("•subtraction of matrics A and B")
    print([a1 - a2, b1 - b2, c1 - c2])
    print([d1 - d2, e1 - e2, f1 - f2])
    print([g1 - g2, h1 - h2, i1 - i2])
    
    print("•multiplication of matrics A and B")
    
    print([(a1 * a2) + (b1 * d2) + (c1 * g2), (a1 * b2) + (b1 * e2) + (c1 * h2), (a1 * c2) + (b1 * f2) + (c1 * i2)])
    print([(d1 * a2) + (e1 * d2) + (f1 * g2), (d1 * b2) + (e1 * e2) + (f1 * h2), (d1 * c2) + (e1 * f2) + (f1 * i2)])
    print([(g1 * a2) + (h1 * d2) + (i1 * g2), (g1 * b2) + (h1 * e2) + (i1 * h2), (g1 * c2) + (h1 * f2) + (i1 * i2)])

else :
    print("Matrix type not supported")