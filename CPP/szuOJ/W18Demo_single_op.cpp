#include <iostream>
using namespace std;
//��Ա����ʵ��
class Base {
	private:
		double num;
	public:
		double getNum() {
			return num;
		}
		Base() { }
		Base(Base &obj) { //��������
			num = obj.getNum();
		}

		Base(double n) {
			num = n;
		}
		//�����Լ�������
		Base& operator++() { //ǰ���� �������
			//����Ŀ���� �ȸ�ֵ �󷵻�
			num+=0.1;
			return *this;
		}

		//����һ������ֵ
		Base operator++(int) { //������ ������int
			//����Ŀ���� �ȷ���ԭֵ Ȼ���ٸ�ֵ
			Base obj(*this);
			num+=0.1;
			return obj;
		}

};

int main() {
	Base b1(3.14),b2(6.66);
	cout<<(++b1).getNum()<<endl;

	Base b3((b2++).getNum());
	cout<<b3.getNum()<<endl;
	cout<<b2.getNum()<<endl;
//output:
//3.24
//6.66
//6.76
	return 0;
}
