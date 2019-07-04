#include <iostream>
using namespace std;
//��Ա����ʵ��
class Base {
	private:
		double num;
	public:
		double getNum() const {
			return num;
		}
		Base() { }
		Base(const Base& obj) { //��������
			num = obj.getNum();
		}

		Base(double n) {
			num = n;
		}
		//�����Լ�������
		Base& operator++() { //++i ǰ���� �������
			//����Ŀ���� �ȸ�ֵ �󷵻�
			num+=0.1;
			return *this;
		}

		//����һ������ֵ
		Base operator++(int) { //i++������ ������int
			//����Ŀ���� �ȷ���ԭֵ Ȼ���ٸ�ֵ
			Base obj(*this);
			num+=0.1;
			return obj;
		}

		//��Ԫ����ʵ��
		//�����Լ�������
		friend Base& operator--(Base& a) { //ǰ���� ������Ϊһ����������
			//����Ŀ���� �ȸ�ֵ �󷵻�
			a.num-=0.1;
			return a;
		}

		//����һ������ֵ
		friend Base operator--(Base & a,int) { //������ ������ ��һ����������,int��
			//����Ŀ���� �ȷ���ԭֵ Ȼ���ٸ�ֵ
			Base obj(a);
			a.num-=0.1;
			return obj;
		}

};

int main() {
	Base b1(3.14),b2(6.66);

	cout<<(b1++).getNum()<<endl; //3.14
	cout<<b1.getNum()<<endl; //3.24

	cout<<(b2--).getNum()<<endl; //6.66
	cout<<b2.getNum()<<endl; //6.56

	cout<<(++b1).getNum()<<endl; //3.34
	cout<<(--b2).getNum()<<endl;//6.46

	Base b3((b2++)); 
	cout<<b3.getNum()<<endl; //6.46
	
	cout<<b2.getNum()<<endl; //6.56
	return 0;
}
