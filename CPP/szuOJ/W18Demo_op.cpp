#include<iostream>
using namespace std;

class CComplex{
public:
    double real, image;
//public:
  CComplex(double a=0.0, double b=0.0)
  {   real = a;      image = b;  }
  CComplex(const CComplex &r)
  {   real = r.real;      image = r.image;  }
  void print() const;
 // CComplex& operator+= (const CComplex &r_c);
  const CComplex& operator+= (double c);//ʵ�����鲿��c
  CComplex operator+ (const CComplex &r_c) const;
  CComplex operator+ (double c) const;
  
  //��Ԫ����ʵ��
friend const CComplex& operator+= (CComplex &r_a,const CComplex &r_b){ // ����(�������)  ���ط� ����(�Ҳ�����  )
   r_a.real += r_b.real;
   r_a.image += r_b.image;
   return r_a;  //��Ա������thisָ�� ���Է����Լ�����ֵ
  }
};
void CComplex::print() const{
   cout<<"real="<<real<<",image="<<image<<endl;
}

//CComplex&  CComplex::operator+= (const CComplex &r_c){
//   real+=r_c.real;
//   image+=r_c.image;
//   return *this;
//}

const CComplex& CComplex::operator+= (double c)//ʵ�����鲿��c{
{   real+=c;
    image+=c;
    return *this;
}
CComplex CComplex::operator+ (const CComplex &r_c) const{
   double r,i;
   r=real+r_c.real;
   i=image+r_c.image;
   return CComplex(r,i);
}
CComplex CComplex::operator+ (double c) const{
   double r,i;
   r=real+c;
   i=image+c;
   return CComplex(r,i);
}
int main(){
  CComplex c1(1,2),c2(3,4),c3;
  int c=5;
  c1+=c2;
  c1.print();
//  c1+=c;
//  c1.print();
  c3=c1+=c2;
  c3.print();
  c3=c1+c;
  c3.print();
  return 1;
}

