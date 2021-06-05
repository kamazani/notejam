provider "aws" {
    version = "~> 2.0" 
    region = var.aws_region
    profile = var.profile
    access_key = ""
    secret_key = ""
}

# create NordCloud vpc

resource "aws_vpc" "main" {
  cidr_block = "10.0.0.0/16"
}

#create a subnet for az-a
resource "aws_subnet" "primary" {
  vpc_id     = aws_vpc.main.id
  availability_zone = var.availability_zone[0]
  cidr_block = "10.0.1.0/24"

  tags = {
    Name = "$(var.environment)"
  }
}
#create a subnet for az-b
resource "aws_subnet" "secondary" {
  vpc_id     = aws_vpc.main.id
  availability_zone = var.availability_zone[1]
  cidr_block = "10.0.2.0/24"

  tags = {
    Name = "$(var.environment)"
  }
}
=================
resource "aws_launch_template" "foobar" {
  name_prefix   = "foobar"
  image_id      = var.ec2_ami
  instance_type = var.instance_type
  key_name = var.ec2_keypair
}

resource "aws_autoscaling_group" "bar" {
  availability_zones = var.availability_zones
  desired_capacity   = 1
  max_size           = 4
  min_size           = 1

  launch_template {
    id      = aws_launch_template.foobar.id
    version = "$Latest"
  }
}
resource "aws_s3_bucket" "b" {
  bucket = "my-NORDcloud123-test-bucket"
  acl    = "private"

  tags = {
    Name = "$(var.environment)"
  }
}
